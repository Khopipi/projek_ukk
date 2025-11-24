<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PengaduanController extends Controller
{
	/**
	 * Display a listing of the resource for the authenticated user.
	 */
	public function index(Request $request)
	{
		$query = Pengaduan::where('user_id', Auth::id());

		if ($request->filled('status')) {
			$query->where('status', $request->status);
		}

		if ($request->filled('kategori')) {
			$query->where('kategori', $request->kategori);
		}

		if ($request->filled('search')) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->where('nomor_pengaduan', 'like', "%{$search}%")
				  ->orWhere('judul', 'like', "%{$search}%")
				  ->orWhere('lokasi', 'like', "%{$search}%");
			});
		}

		$pengaduans = $query->latest()->paginate(10);

		return view('user.pengaduan.index', compact('pengaduans'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		$kategoris = ['Infrastruktur', 'Kebersihan', 'Keamanan', 'Pelayanan Publik', 'Kesehatan', 'Pendidikan', 'Lainnya'];
		return view('user.pengaduan.create', compact('kategoris'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$validated = $request->validate([
			'kategori' => 'required|in:Infrastruktur,Kebersihan,Keamanan,Pelayanan Publik,Kesehatan,Pendidikan,Lainnya',
			'judul' => 'required|string|max:255',
			'isi_pengaduan' => 'required|string',
			'lokasi' => 'nullable|string|max:255',
			'foto_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
			'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
			'foto_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
		]);

		$validated['user_id'] = Auth::id();

		for ($i = 1; $i <= 3; $i++) {
			$fieldName = "foto_{$i}";
			if ($request->hasFile($fieldName)) {
				$file = $request->file($fieldName);
				// Sanitize original filename to avoid spaces or problematic chars
				$originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				$safeName = Str::slug($originalName);
				$ext = $file->getClientOriginalExtension();
				$filename = time() . "_foto{$i}_" . $safeName . '.' . $ext;
				// Store on the public disk under folder 'pengaduan'. Use public disk.
				$file->storeAs('pengaduan', $filename, 'public');
				$validated[$fieldName] = $filename;
			}
		}

		Pengaduan::create($validated);

		return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim!');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Pengaduan $pengaduan)
	{
		// Ensure ownership
		if ($pengaduan->user_id !== Auth::id()) {
			abort(403, 'Unauthorized action.');
		}

		return view('user.pengaduan.show', compact('pengaduan'));
	}

	/**
	 * Serve an image file for a pengaduan.
	 * Tries multiple strategies: exact DB match, partial match, disk-based similarity, and "best guess" fallback.
	 * Allows admins to access any user's files; regular users only their own.
	 */
	public function file($filename)
	{
		$filenameToServe = null;
		$decoded = urldecode($filename);
		$candidates = [$filename, $decoded];

		// Strategy 1: Try exact match in DB
		foreach ($candidates as $candidate) {
			$q = Pengaduan::query();
			if (!Auth::user() || Auth::user()->role !== 'admin') {
				$q->where('user_id', Auth::id());
			}
			$pengaduan = $q->where(function($q2) use ($candidate) {
				$q2->where('foto_1', $candidate)
				   ->orWhere('foto_2', $candidate)
				   ->orWhere('foto_3', $candidate);
			})->first();

			if ($pengaduan) {
				$filenameToServe = $candidate;
				break;
			}
		}

		// Strategy 2: Try partial match (LIKE) in DB
		if (empty($filenameToServe)) {
			$q = Pengaduan::query();
			if (!Auth::user() || Auth::user()->role !== 'admin') {
				$q->where('user_id', Auth::id());
			}
			$pengaduan = $q->where(function($q2) use ($filename) {
				$q2->where('foto_1', 'like', "%{$filename}%")
				   ->orWhere('foto_2', 'like', "%{$filename}%")
				   ->orWhere('foto_3', 'like', "%{$filename}%");
			})->first();

			if ($pengaduan) {
				foreach (['foto_1', 'foto_2', 'foto_3'] as $col) {
					if ($pengaduan->$col && str_contains($pengaduan->$col, $filename)) {
						$filenameToServe = $pengaduan->$col;
						break;
					}
				}
			}
		}

		// Strategy 3: Disk-based normalized similarity match
		if (empty($filenameToServe)) {
			$normalize = function($s) {
				return strtolower(preg_replace('/[^A-Za-z0-9]/', '', (string) $s));
			};
			$reqNorm = $normalize($decoded);

			$files = Storage::disk('public')->files('pengaduan');
			foreach ($files as $f) {
				$base = basename($f);
				if ($base === $decoded || $base === $filename) {
					$filenameToServe = $base;
					break;
				}

				$storageNorm = $normalize($base);
				if ($reqNorm && $storageNorm && (strpos($storageNorm, $reqNorm) !== false || strpos($reqNorm, $storageNorm) !== false)) {
					$filenameToServe = $base;
					Log::info("Pengaduan file match: requested='{$decoded}' matched_to='{$base}'");
					break;
				}
			}
		}

		// Strategy 4: "Best guess" fallback – search storage for any file that looks similar
		// This helps when filenames don't match DB exactly (e.g., old uploads with different names)
		if (empty($filenameToServe)) {
			// Extract any numeric timestamp or key identifiers from the requested filename
			if (preg_match('/(\d+).*foto[123]/i', $decoded, $matches)) {
				$timestamp = $matches[1];
				$files = Storage::disk('public')->files('pengaduan');
				foreach ($files as $f) {
					$base = basename($f);
					// Match if storage file contains the same timestamp
					if (strpos($base, $timestamp) !== false) {
						$filenameToServe = $base;
						Log::info("Pengaduan file best-guess: requested='{$decoded}' matched_to='{$base}' via timestamp");
						break;
					}
				}
			}
		}

		// Final attempt: check if the file exists on disk directly
		if (empty($filenameToServe)) {
			$possiblePaths = [
				'pengaduan/' . $decoded,
				'pengaduan/' . $filename,
			];
			foreach ($possiblePaths as $p) {
				if (Storage::disk('public')->exists($p)) {
					$filenameToServe = basename($p);
					Log::info("Pengaduan file found on disk: {$p}");
					break;
				}
			}
		}

		// If no match found, abort 404
		if (empty($filenameToServe)) {
			Log::warning("Pengaduan file not found: requested='{$decoded}', user=" . Auth::id());
			abort(404);
		}

		// Serve the file
		$path = storage_path('app/public/pengaduan/' . $filenameToServe);
		if (!file_exists($path)) {
			// Try via Storage disk as fallback
			if (Storage::disk('public')->exists('pengaduan/' . $filenameToServe)) {
				$path = Storage::disk('public')->path('pengaduan/' . $filenameToServe);
			} else {
				abort(404);
			}
		}

		return response()->file($path);
	}

	/**
	 * Debug helper: return pengaduan filenames for current user and storage files list.
	 * Accessible only to authenticated users (route is in auth + cekRole:user group).
	 */
	public function debugFiles()
	{
		// For admins, show all pengaduan; for users, show only theirs
		$query = Pengaduan::query();
		if (!Auth::user() || Auth::user()->role !== 'admin') {
			$query->where('user_id', Auth::id());
		}
		$pengaduans = $query->get(['id', 'user_id', 'foto_1', 'foto_2', 'foto_3']);
		$storageFiles = Storage::disk('public')->files('pengaduan');

		// Normalize storage file names (just basename)
		$storageBasenames = array_map(function($p) {
			return basename($p);
		}, $storageFiles);

		return response()->json([
			'pengaduan_files' => $pengaduans->map(function($p) { return [
				'id' => $p->id,
				'foto_1' => $p->foto_1,
				'foto_2' => $p->foto_2,
				'foto_3' => $p->foto_3,
			]; }),
			'storage_files' => $storageBasenames,
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Pengaduan $pengaduan)
	{
		if ($pengaduan->user_id !== Auth::id()) {
			abort(403, 'Unauthorized action.');
		}

		if (!in_array($pengaduan->status, ['Menunggu', 'Ditolak'])) {
			return redirect()->route('pengaduan.index')->with('error', 'Pengaduan yang sedang diproses tidak dapat dihapus.');
		}

		$files = [$pengaduan->foto_1, $pengaduan->foto_2, $pengaduan->foto_3];
		foreach ($files as $file) {
			if ($file) {
				Storage::disk('public')->delete('pengaduan/' . $file);
			}
		}

		$pengaduan->delete();
		return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus!');
	}
}

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
		$timestamp = time(); // Use fixed timestamp for all files in this upload

		for ($i = 1; $i <= 3; $i++) {
			$fieldName = "foto_{$i}";
			if ($request->hasFile($fieldName)) {
				$file = $request->file($fieldName);
				// Keep original filename and just prepend timestamp
				$originalName = $file->getClientOriginalName();
				$ext = $file->getClientOriginalExtension();
				
				// Create unique filename with timestamp only, keep original name readable
				$filename = $timestamp . '_foto' . $i . '_' . uniqid() . '.' . $ext;
				
				// Store on the public disk under folder 'pengaduan'
				if ($file->storeAs('pengaduan', $filename, 'public')) {
					$validated[$fieldName] = $filename;
					Log::info("Pengaduan file uploaded: {$filename}");
				} else {
					Log::error("Failed to upload pengaduan file: {$fieldName}");
				}
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
	 * Download file from pengaduan storage
	 */
	public function download($filename)
	{
		$filePath = 'pengaduan/' . $filename;
		
		// Check if file exists
		if (!Storage::disk('public')->exists($filePath)) {
			abort(404, 'File not found');
		}

		// Get full path using DIRECTORY_SEPARATOR for cross-platform compatibility
		$fullPath = storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'public', 'pengaduan', $filename]));

		// Return file for download
		return response()->download($fullPath, $filename);
	}

	/**
	 * Serve an image file for a pengaduan.
	 * Serves files from storage/app/public/pengaduan/ folder.
	 * Allows admins to access any user's files; regular users only their own.
	 */
	public function file($filename)
	{
		try {
			$filenameToServe = null;
			$decoded = urldecode($filename);
			Log::info("Attempting to serve pengaduan file: requested='{$filename}', decoded='{$decoded}'");

			// Authorization check: Admin can access all, users only their own
			$query = Pengaduan::query();
			if (Auth::user() && Auth::user()->role !== 'admin') {
				$query->where('user_id', Auth::id());
			}

			// Strategy 1: Try exact match in DB
			$pengaduan = $query->where(function($q) use ($decoded, $filename) {
				$q->where('foto_1', $decoded)
				  ->orWhere('foto_1', $filename)
				  ->orWhere('foto_2', $decoded)
				  ->orWhere('foto_2', $filename)
				  ->orWhere('foto_3', $decoded)
				  ->orWhere('foto_3', $filename);
			})->first();

			if ($pengaduan) {
				foreach (['foto_1', 'foto_2', 'foto_3'] as $col) {
					if ($pengaduan->$col === $decoded || $pengaduan->$col === $filename) {
						$filenameToServe = $pengaduan->$col;
						Log::info("Pengaduan file exact match found in DB: {$filenameToServe}");
						break;
					}
				}
			}

			// Strategy 2: Direct file existence check
			if (empty($filenameToServe)) {
				$possiblePaths = [
					'pengaduan/' . $decoded,
					'pengaduan/' . $filename,
				];
				
				foreach ($possiblePaths as $path) {
					if (Storage::disk('public')->exists($path)) {
						$filenameToServe = basename($path);
						Log::info("Pengaduan file found on disk directly: {$filenameToServe}");
						break;
					}
				}
			}

			// Strategy 3: List files in storage and try to match
			if (empty($filenameToServe)) {
				$files = Storage::disk('public')->files('pengaduan');
				foreach ($files as $f) {
					$base = basename($f);
					if ($base === $decoded || $base === $filename) {
						$filenameToServe = $base;
						Log::info("Pengaduan file found via storage listing: {$base}");
						break;
					}
				}
			}

			// If still not found, abort
			if (empty($filenameToServe)) {
				Log::warning("Pengaduan file not found - requested: '{$decoded}', user: " . (Auth::id() ?? 'guest'));
				abort(404, "File tidak ditemukan: {$decoded}");
			}

			// Serve the file from storage
			$path = storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'public', 'pengaduan', $filenameToServe]));
			
			if (!file_exists($path)) {
				Log::error("File path does not exist: {$path}");
				abort(404, "File tidak dapat diakses: {$filenameToServe}");
			}

			Log::info("Serving pengaduan file: {$path}");
			return response()->file($path);

		} catch (\Exception $e) {
			Log::error("Error serving pengaduan file: " . $e->getMessage());
			abort(500, "Terjadi kesalahan saat mengakses file");
		}
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

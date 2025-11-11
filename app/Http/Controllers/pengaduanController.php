<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
				$filename = time() . "_foto{$i}_" . $file->getClientOriginalName();
				$file->storeAs('public/pengaduan', $filename);
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
				Storage::delete('public/pengaduan/' . $file);
			}
		}

		$pengaduan->delete();
		return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus!');
	}
}

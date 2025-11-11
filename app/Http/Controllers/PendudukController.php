<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('kk', 'like', "%{$search}%");
            });
        }

        // Filter by jenis kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by status perkawinan
        if ($request->has('status_perkawinan') && $request->status_perkawinan != '') {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        $penduduks = $query->latest()->paginate(10);

        return view('admin.penduduk.index', compact('penduduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.penduduk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks,nik',
            'kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|size:5',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'status_dalam_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'status_kependudukan' => 'required|in:Tetap,Tidak Tetap,Pendatang',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/penduduk', $filename);
            $validated['foto'] = $filename;
        }

        Penduduk::create($validated);

        return redirect()->route('penduduk.index')
                         ->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        return view('admin.penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks,nik,' . $penduduk->id,
            'kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|size:5',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'status_dalam_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'status_kependudukan' => 'required|in:Tetap,Tidak Tetap,Pendatang',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($penduduk->foto) {
                Storage::delete('public/penduduk/' . $penduduk->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/penduduk', $filename);
            $validated['foto'] = $filename;
        }

        $penduduk->update($validated);

        return redirect()->route('penduduk.index')
                         ->with('success', 'Data penduduk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        // Delete photo if exists
        if ($penduduk->foto) {
            Storage::delete('public/penduduk/' . $penduduk->foto);
        }

        $penduduk->delete();

        return redirect()->route('penduduk.index')
                         ->with('success', 'Data penduduk berhasil dihapus!');
    }

    /**
     * Export data penduduk to Excel/PDF
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // You can use packages like maatwebsite/excel or barryvdh/laravel-dompdf
    }
}
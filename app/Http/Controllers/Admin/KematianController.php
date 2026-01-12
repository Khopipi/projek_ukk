<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kematian;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class KematianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kematians = Kematian::with('penduduk')->latest()->paginate(15);
        return view('admin.kematian.index', compact('kematians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        return view('admin.kematian.create', compact('penduduks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $penduduk_id = $request->input('penduduk_id');
        $nama_warga = $request->input('nama_warga');
        
        // Cek apakah ini input bebas atau pilih dari database
        // Input bebas: penduduk_id = '0' atau nama_warga ada
        $isCustomInput = ($penduduk_id == 0 || $penduduk_id == '0' || empty($penduduk_id)) || !empty($nama_warga);
        
        if ($isCustomInput && !empty($nama_warga)) {
            // Input bebas - tidak perlu validasi ketat penduduk_id
            $validated = $request->validate([
                'tanggal_kematian' => 'required|date',
                'penyebab_kematian' => 'nullable|string',
                'tempat_kematian' => 'nullable|string',
                'rs_atau_rumah' => 'nullable|string',
                'usia_saat_meninggal' => 'nullable|string',
                'nama_diperiksa_oleh' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ], [
                'tanggal_kematian.required' => 'Tanggal kematian harus diisi',
                'tanggal_kematian.date' => 'Format tanggal tidak valid',
            ]);
            
            // Untuk input bebas
            $validated['penduduk_id'] = null;
            $validated['nama_warga'] = $nama_warga;
        } else {
            // Jika pilih dari database
            $validated = $request->validate([
                'penduduk_id' => 'required|numeric|exists:penduduks,id|unique:kematians,penduduk_id',
                'tanggal_kematian' => 'required|date',
                'penyebab_kematian' => 'nullable|string',
                'tempat_kematian' => 'nullable|string',
                'rs_atau_rumah' => 'nullable|string',
                'usia_saat_meninggal' => 'nullable|string',
                'nama_diperiksa_oleh' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ], [
                'penduduk_id.required' => 'Pilih penduduk terlebih dahulu',
                'penduduk_id.numeric' => 'Format ID penduduk tidak valid',
                'penduduk_id.exists' => 'Penduduk tidak ditemukan',
                'penduduk_id.unique' => 'Penduduk ini sudah tercatat meninggal',
                'tanggal_kematian.required' => 'Tanggal kematian harus diisi',
                'tanggal_kematian.date' => 'Format tanggal tidak valid',
            ]);
            $validated['nama_warga'] = null;
        }

        $validated['input_oleh'] = auth()->user()->name;

        Kematian::create($validated);

        return redirect()->route('admin.kematian.index')
                        ->with('success', 'Data kematian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kematian $kematian)
    {
        return view('admin.kematian.show', compact('kematian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kematian $kematian)
    {
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        return view('admin.kematian.edit', compact('kematian', 'penduduks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kematian $kematian)
    {
        $penduduk_id = $request->input('penduduk_id');
        $nama_warga = $request->input('nama_warga');
        
        // Cek apakah ini input bebas atau pilih dari database
        $isCustomInput = ($penduduk_id == 0 || $penduduk_id == '0' || empty($penduduk_id)) || !empty($nama_warga);
        
        if ($isCustomInput && !empty($nama_warga)) {
            // Input bebas
            $validated = $request->validate([
                'tanggal_kematian' => 'required|date',
                'penyebab_kematian' => 'nullable|string',
                'tempat_kematian' => 'nullable|string',
                'rs_atau_rumah' => 'nullable|string',
                'usia_saat_meninggal' => 'nullable|string',
                'nama_diperiksa_oleh' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);
            $validated['penduduk_id'] = null;
            $validated['nama_warga'] = $nama_warga;
        } else {
            // Jika pilih dari database
            $validated = $request->validate([
                'penduduk_id' => 'required|numeric|exists:penduduks,id|unique:kematians,penduduk_id,' . $kematian->id,
                'tanggal_kematian' => 'required|date',
                'penyebab_kematian' => 'nullable|string',
                'tempat_kematian' => 'nullable|string',
                'rs_atau_rumah' => 'nullable|string',
                'usia_saat_meninggal' => 'nullable|string',
                'nama_diperiksa_oleh' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);
            $validated['nama_warga'] = null;
        }

        $kematian->update($validated);

        return redirect()->route('admin.kematian.index')
                        ->with('success', 'Data kematian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kematian $kematian)
    {
        $kematian->delete();

        return redirect()->route('admin.kematian.index')
                        ->with('success', 'Data kematian berhasil dihapus');
    }
}


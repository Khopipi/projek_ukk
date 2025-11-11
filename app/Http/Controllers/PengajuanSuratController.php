<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PengajuanSurat::with('user')
            ->where('user_id', Auth::id());

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by jenis surat
        if ($request->has('jenis_surat') && $request->jenis_surat != '') {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('nik_pemohon', 'like', "%{$search}%");
            });
        }

        $pengajuans = $query->latest()->paginate(10);

        return view('user.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisSurat = [
            'Surat Nikah',
            'Pembuatan KTP',
            'Surat Tanah',
            'Surat Warisan',
            'Surat Domisili',
            'Surat Kelahiran',
            'Surat Keterangan Tidak Mampu'
        ];

        return view('user.pengajuan.create', compact('jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Surat Nikah,Pembuatan KTP,Surat Tanah,Surat Warisan,Surat Domisili,Surat Kelahiran,Surat Keterangan Tidak Mampu',
            'keperluan' => 'required|string',
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => 'required|string|size:16',
            'tempat_lahir_pemohon' => 'required|string|max:255',
            'tanggal_lahir_pemohon' => 'required|date',
            'jenis_kelamin_pemohon' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan_pemohon' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string',
            'no_telepon_pemohon' => 'required|string|max:15',
            'file_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'data_tambahan' => 'nullable|array'
        ]);

        $validated['user_id'] = Auth::id();

        // Handle file uploads
        if ($request->hasFile('file_ktp')) {
            $file = $request->file('file_ktp');
            $filename = time() . '_ktp_' . $file->getClientOriginalName();
            $file->storeAs('public/pengajuan', $filename);
            $validated['file_ktp'] = $filename;
        }

        if ($request->hasFile('file_kk')) {
            $file = $request->file('file_kk');
            $filename = time() . '_kk_' . $file->getClientOriginalName();
            $file->storeAs('public/pengajuan', $filename);
            $validated['file_kk'] = $filename;
        }

        // Handle optional files
        for ($i = 1; $i <= 3; $i++) {
            $fieldName = "file_pendukung_{$i}";
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $filename = time() . "_pendukung{$i}_" . $file->getClientOriginalName();
                $file->storeAs('public/pengajuan', $filename);
                $validated[$fieldName] = $filename;
            }
        }

        PengajuanSurat::create($validated);

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil diajukan! Silakan tunggu proses verifikasi dari admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanSurat $pengajuan)
    {
        // Pastikan user hanya bisa melihat pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanSurat $pengajuan)
    {
        // Pastikan user hanya bisa edit pengajuannya sendiri
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa edit jika status masih Menunggu
        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('pengajuan.show', $pengajuan->id)
                ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $jenisSurat = [
            'Surat Nikah',
            'Pembuatan KTP',
            'Surat Tanah',
            'Surat Warisan',
            'Surat Domisili',
            'Surat Kelahiran',
            'Surat Keterangan Tidak Mampu'
        ];

        return view('user.pengajuan.edit', compact('pengajuan', 'jenisSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanSurat $pengajuan)
    {
        // Validasi kepemilikan
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi status
        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('pengajuan.show', $pengajuan->id)
                ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $validated = $request->validate([
            'jenis_surat' => 'required|in:Surat Nikah,Pembuatan KTP,Surat Tanah,Surat Warisan,Surat Domisili,Surat Kelahiran,Surat Keterangan Tidak Mampu',
            'keperluan' => 'required|string',
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => 'required|string|size:16',
            'tempat_lahir_pemohon' => 'required|string|max:255',
            'tanggal_lahir_pemohon' => 'required|date',
            'jenis_kelamin_pemohon' => 'required|in:Laki-laki,Perempuan',
            'pekerjaan_pemohon' => 'required|string|max:255',
            'alamat_pemohon' => 'required|string',
            'no_telepon_pemohon' => 'required|string|max:15',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_pendukung_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'data_tambahan' => 'nullable|array'
        ]);

        // Handle file uploads with deletion of old files
        if ($request->hasFile('file_ktp')) {
            if ($pengajuan->file_ktp) {
                Storage::delete('public/pengajuan/' . $pengajuan->file_ktp);
            }
            $file = $request->file('file_ktp');
            $filename = time() . '_ktp_' . $file->getClientOriginalName();
            $file->storeAs('public/pengajuan', $filename);
            $validated['file_ktp'] = $filename;
        }

        if ($request->hasFile('file_kk')) {
            if ($pengajuan->file_kk) {
                Storage::delete('public/pengajuan/' . $pengajuan->file_kk);
            }
            $file = $request->file('file_kk');
            $filename = time() . '_kk_' . $file->getClientOriginalName();
            $file->storeAs('public/pengajuan', $filename);
            $validated['file_kk'] = $filename;
        }

        // Handle optional files
        for ($i = 1; $i <= 3; $i++) {
            $fieldName = "file_pendukung_{$i}";
            if ($request->hasFile($fieldName)) {
                $oldFile = $pengajuan->{$fieldName};
                if ($oldFile) {
                    Storage::delete('public/pengajuan/' . $oldFile);
                }
                $file = $request->file($fieldName);
                $filename = time() . "_pendukung{$i}_" . $file->getClientOriginalName();
                $file->storeAs('public/pengajuan', $filename);
                $validated[$fieldName] = $filename;
            }
        }

        $pengajuan->update($validated);

        return redirect()->route('pengajuan.show', $pengajuan->id)
            ->with('success', 'Pengajuan surat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanSurat $pengajuan)
    {
        // Validasi kepemilikan
        if ($pengajuan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hanya bisa hapus jika status Menunggu atau Ditolak
        if (!in_array($pengajuan->status, ['Menunggu', 'Ditolak'])) {
            return redirect()->route('pengajuan.index')
                ->with('error', 'Pengajuan yang sedang diproses tidak dapat dihapus.');
        }

        // Delete files
        $files = [
            $pengajuan->file_ktp,
            $pengajuan->file_kk,
            $pengajuan->file_pendukung_1,
            $pengajuan->file_pendukung_2,
            $pengajuan->file_pendukung_3
        ];

        foreach ($files as $file) {
            if ($file) {
                Storage::delete('public/pengajuan/' . $file);
            }
        }

        $pengajuan->delete();

        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan surat berhasil dihapus!');
    }
}
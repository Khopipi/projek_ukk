<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerifikasiPengajuanController extends Controller
{
    /**
     * Display a listing of all pengajuan
     */
    public function index(Request $request)
    {
        $query = PengajuanSurat::with('user');

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
                  ->orWhere('nik_pemohon', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuans = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total' => PengajuanSurat::count(),
            'menunggu' => PengajuanSurat::where('status', 'Menunggu')->count(),
            'diproses' => PengajuanSurat::where('status', 'Diproses')->count(),
            'disetujui' => PengajuanSurat::where('status', 'Disetujui')->count(),
            'ditolak' => PengajuanSurat::where('status', 'Ditolak')->count(),
            'selesai' => PengajuanSurat::where('status', 'Selesai')->count(),
        ];

        return view('admin.pengajuan.index', compact('pengajuans', 'stats'));
    }

    /**
     * Display the specified pengajuan
     */
    public function show(PengajuanSurat $pengajuan)
    {
        $pengajuan->load('user', 'admin');
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Update status to Diproses
     */
    public function proses(PengajuanSurat $pengajuan)
    {
        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuan->update([
            'status' => 'Diproses',
            'diproses_oleh' => Auth::id()
        ]);

        return back()->with('success', 'Status pengajuan berhasil diubah menjadi Diproses.');
    }

    /**
     * Approve pengajuan (Disetujui)
     */
    public function approve(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:1000'
        ]);

        if (!in_array($pengajuan->status, ['Menunggu', 'Diproses'])) {
            return back()->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        $pengajuan->update([
            'status' => 'Disetujui',
            'catatan_admin' => $request->catatan_admin,
            'tanggal_disetujui' => now(),
            'diproses_oleh' => Auth::id()
        ]);

        return back()->with('success', 'Pengajuan berhasil disetujui! Silakan upload surat hasil.');
    }

    /**
     * Reject pengajuan (Ditolak)
     */
    public function reject(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:1000'
        ]);

        if (!in_array($pengajuan->status, ['Menunggu', 'Diproses'])) {
            return back()->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        $pengajuan->update([
            'status' => 'Ditolak',
            'catatan_admin' => $request->catatan_admin,
            'tanggal_ditolak' => now(),
            'diproses_oleh' => Auth::id()
        ]);

        return back()->with('success', 'Pengajuan telah ditolak.');
    }

    /**
     * Upload surat hasil & set status Selesai
     */
    public function uploadSurat(Request $request, PengajuanSurat $pengajuan)
    {
        $request->validate([
            'file_surat_hasil' => 'required|file|mimes:pdf|max:5120'
        ]);

        if ($pengajuan->status !== 'Disetujui') {
            return back()->with('error', 'Hanya pengajuan yang disetujui yang dapat diupload surat hasilnya.');
        }

        // Delete old file if exists
        if ($pengajuan->file_surat_hasil) {
            Storage::delete('public/surat_hasil/' . $pengajuan->file_surat_hasil);
        }

        // Upload new file
        $file = $request->file('file_surat_hasil');
        $filename = time() . '_' . $pengajuan->nomor_pengajuan . '.pdf';
        $file->storeAs('public/surat_hasil', $filename);

        $pengajuan->update([
            'file_surat_hasil' => $filename,
            'status' => 'Selesai',
            'tanggal_selesai' => now()
        ]);

        return back()->with('success', 'Surat hasil berhasil diupload! Status pengajuan: Selesai.');
    }

    /**
     * Delete surat hasil file
     */
    public function deleteSurat(PengajuanSurat $pengajuan)
    {
        if (!$pengajuan->file_surat_hasil) {
            return back()->with('error', 'Tidak ada file surat untuk dihapus.');
        }

        // Delete file
        Storage::delete('public/surat_hasil/' . $pengajuan->file_surat_hasil);

        $pengajuan->update([
            'file_surat_hasil' => null,
            'status' => 'Disetujui',
            'tanggal_selesai' => null
        ]);

        return back()->with('success', 'File surat hasil berhasil dihapus.');
    }

    /**
     * Bulk action untuk multiple pengajuan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:proses,approve,reject,delete',
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:pengajuan_surats,id'
        ]);

        $pengajuans = PengajuanSurat::whereIn('id', $request->selected_ids)->get();

        switch ($request->action) {
            case 'proses':
                foreach ($pengajuans as $pengajuan) {
                    if ($pengajuan->status === 'Menunggu') {
                        $pengajuan->update([
                            'status' => 'Diproses',
                            'diproses_oleh' => Auth::id()
                        ]);
                    }
                }
                return back()->with('success', 'Pengajuan terpilih berhasil diproses.');

            case 'approve':
                foreach ($pengajuans as $pengajuan) {
                    if (in_array($pengajuan->status, ['Menunggu', 'Diproses'])) {
                        $pengajuan->update([
                            'status' => 'Disetujui',
                            'tanggal_disetujui' => now(),
                            'diproses_oleh' => Auth::id()
                        ]);
                    }
                }
                return back()->with('success', 'Pengajuan terpilih berhasil disetujui.');

            case 'delete':
                foreach ($pengajuans as $pengajuan) {
                    // Delete files
                    $files = [
                        'public/pengajuan/' . $pengajuan->file_ktp,
                        'public/pengajuan/' . $pengajuan->file_kk,
                        'public/pengajuan/' . $pengajuan->file_pendukung_1,
                        'public/pengajuan/' . $pengajuan->file_pendukung_2,
                        'public/pengajuan/' . $pengajuan->file_pendukung_3,
                        'public/surat_hasil/' . $pengajuan->file_surat_hasil
                    ];
                    
                    foreach ($files as $file) {
                        if ($file && Storage::exists($file)) {
                            Storage::delete($file);
                        }
                    }
                    
                    $pengajuan->delete();
                }
                return back()->with('success', 'Pengajuan terpilih berhasil dihapus.');

            default:
                return back()->with('error', 'Aksi tidak valid.');
        }
    }
}
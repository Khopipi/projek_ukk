<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiPengaduanController extends Controller
{
    /**
     * Display a listing of pengaduan untuk admin
     */
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'admin']);

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pengaduan', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan prioritas
        if ($request->has('prioritas') && $request->prioritas != '') {
            $query->where('prioritas', $request->prioritas);
        }

        $pengaduans = $query->latest()->paginate(10)->withQueryString();

        // Statistik
        $stats = [
            'total' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'Ditolak')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduans', 'stats'));
    }

    /**
     * Display the specified pengaduan
     */
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'admin']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Proses pengaduan (ubah status ke Diproses)
     */
    public function proses(Pengaduan $pengaduan)
    {
        if (!in_array($pengaduan->status, ['Menunggu'])) {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat diproses.');
        }

        $pengaduan->update([
            'status' => 'Diproses',
            'ditanggapi_oleh' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil ditandai sedang diproses.');
    }

    /**
     * Tanggapi pengaduan
     */
    public function tanggapi(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan_admin' => 'required|string|min:10',
            'prioritas' => 'nullable|in:Rendah,Sedang,Tinggi,Mendesak',
        ], [
            'tanggapan_admin.required' => 'Tanggapan wajib diisi',
            'tanggapan_admin.min' => 'Tanggapan minimal 10 karakter',
        ]);

        if (!in_array($pengaduan->status, ['Menunggu', 'Diproses'])) {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat ditanggapi.');
        }

        $updateData = [
            'status' => 'Diproses',
            'tanggapan_admin' => $request->tanggapan_admin,
            'ditanggapi_oleh' => Auth::id(),
            'tanggal_ditanggapi' => now(),
        ];

        if ($request->has('prioritas') && $request->prioritas != '') {
            $updateData['prioritas'] = $request->prioritas;
        }

        $pengaduan->update($updateData);

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    /**
     * Selesaikan pengaduan
     */
    public function selesai(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan_admin' => 'required|string|min:10',
        ], [
            'tanggapan_admin.required' => 'Tanggapan penyelesaian wajib diisi',
            'tanggapan_admin.min' => 'Tanggapan minimal 10 karakter',
        ]);

        if (!in_array($pengaduan->status, ['Diproses'])) {
            return redirect()->back()->with('error', 'Hanya pengaduan yang sedang diproses yang dapat diselesaikan.');
        }

        $pengaduan->update([
            'status' => 'Selesai',
            'tanggapan_admin' => $request->tanggapan_admin,
            'ditanggapi_oleh' => Auth::id(),
            'tanggal_selesai' => now(),
            'tanggal_ditanggapi' => $pengaduan->tanggal_ditanggapi ?? now(),
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil diselesaikan.');
    }

    /**
     * Tolak pengaduan
     */
    public function tolak(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'tanggapan_admin' => 'required|string|min:10',
        ], [
            'tanggapan_admin.required' => 'Alasan penolakan wajib diisi',
            'tanggapan_admin.min' => 'Alasan penolakan minimal 10 karakter',
        ]);

        if (!in_array($pengaduan->status, ['Menunggu', 'Diproses'])) {
            return redirect()->back()->with('error', 'Pengaduan ini tidak dapat ditolak.');
        }

        $pengaduan->update([
            'status' => 'Ditolak',
            'tanggapan_admin' => $request->tanggapan_admin,
            'ditanggapi_oleh' => Auth::id(),
            'tanggal_ditanggapi' => now(),
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil ditolak.');
    }

    /**
     * Update prioritas pengaduan
     */
    public function updatePrioritas(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Mendesak',
        ]);

        $pengaduan->update([
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->back()->with('success', 'Prioritas pengaduan berhasil diperbarui.');
    }

    /**
     * Bulk action untuk multiple pengaduan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:proses,tolak',
            'pengaduan_ids' => 'required|array',
            'pengaduan_ids.*' => 'exists:pengaduans,id',
            'tanggapan_admin' => 'required_if:action,tolak|string|min:10',
        ]);

        $pengaduanIds = $request->pengaduan_ids;
        $action = $request->action;

        switch ($action) {
            case 'proses':
                Pengaduan::whereIn('id', $pengaduanIds)
                    ->where('status', 'Menunggu')
                    ->update([
                        'status' => 'Diproses',
                        'ditanggapi_oleh' => Auth::id(),
                    ]);
                $message = 'Pengaduan terpilih berhasil ditandai sedang diproses.';
                break;

            case 'tolak':
                Pengaduan::whereIn('id', $pengaduanIds)
                    ->whereIn('status', ['Menunggu', 'Diproses'])
                    ->update([
                        'status' => 'Ditolak',
                        'tanggapan_admin' => $request->tanggapan_admin,
                        'ditanggapi_oleh' => Auth::id(),
                        'tanggal_ditanggapi' => now(),
                    ]);
                $message = 'Pengaduan terpilih berhasil ditolak.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}

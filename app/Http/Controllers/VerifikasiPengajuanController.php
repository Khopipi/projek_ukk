<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use App\Models\DownloadHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanHasilMail;

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

        // Record diproses timestamp inside data_tambahan for tracking
        $data = $pengajuan->data_tambahan ?? [];
        $data['ts_diproses'] = now()->toDateTimeString();

        $pengajuan->update([
            'status' => 'Diproses',
            'diproses_oleh' => Auth::id(),
            'data_tambahan' => $data
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
     * Preview surat dalam HTML sebelum generate PDF
     */
    public function previewSurat(PengajuanSurat $pengajuan)
    {
        return view('admin.pengajuan.preview-surat', compact('pengajuan'));
    }

    /**
     * Download PDF with tracking history
     */
    public function downloadPdf(PengajuanSurat $pengajuan)
    {
        // Check if PDF exists
        if (!$pengajuan->file_surat_hasil) {
            return back()->with('error', 'PDF surat hasil belum tersedia. Silakan generate terlebih dahulu.');
        }

        $filePath = storage_path('app/public/surat_hasil/' . $pengajuan->file_surat_hasil);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File PDF tidak ditemukan.');
        }

        try {
            // Log download history
            DownloadHistory::create([
                'pengajuan_surat_id' => $pengajuan->id,
                'user_id' => Auth::id(),
                'filename' => $pengajuan->file_surat_hasil,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // Create safe filename for download (remove special characters)
            $downloadName = preg_replace('/[^A-Za-z0-9\-_.]/', '_', $pengajuan->nomor_pengajuan) . '.pdf';

            // Download file
            return response()->download($filePath, $downloadName);
        } catch (\Throwable $e) {
            Log::error('Download PDF failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal download file: ' . $e->getMessage());
        }
    }

    /**
     * Generate a PDF document for the pengajuan (Surat Hasil) and save it.
     */
    public function generateSurat(PengajuanSurat $pengajuan)
    {
        // Check for PDF generation library availability
        if (!class_exists(\Barryvdh\DomPDF\Facade::class) && !class_exists(\Dompdf\Dompdf::class)) {
            return back()->with('error', 'PDF generator not available. Please install "barryvdh/laravel-dompdf" (run: composer require barryvdh/laravel-dompdf).');
        }

        // Render HTML from Blade
        $html = view('pengajuan.pdf', compact('pengajuan'))->render();

        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $pengajuan->nomor_pengajuan) . '.pdf';
        $directory = 'surat_hasil';

        try {
            // Ensure directory exists
            $fullDirectory = storage_path('app/public/' . $directory);
            if (!is_dir($fullDirectory)) {
                mkdir($fullDirectory, 0755, true);
            }

            // Generate PDF content
            $pdfContent = null;
            if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
                $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
                $pdfContent = $pdf->output();
            } else {
                $dompdf = new \Dompdf\Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $pdfContent = $dompdf->output();
            }

            // Full path untuk file
            $diskPath = $fullDirectory . DIRECTORY_SEPARATOR . $filename;
            
            // Store file
            file_put_contents($diskPath, $pdfContent);

            // Verify file was created
            if (!file_exists($diskPath)) {
                throw new \Exception('File PDF gagal disimpan ke disk di: ' . $diskPath);
            }

            // Update database
            $pengajuan->update([
                'file_surat_hasil' => $filename,
                'status' => 'Selesai',
                'tanggal_selesai' => now()
            ]);

            Log::info('PDF generated successfully: ' . $diskPath);
            return back()->with('success', 'Surat hasil berhasil digenerate dan disimpan.');
        } catch (\Throwable $e) {
            Log::error('Generate surat failed: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Send the generated PDF to the user via email. If PDF does not exist, generate it first.
     */
    public function sendPdf(PengajuanSurat $pengajuan)
    {
        // Ensure user has email
        $userEmail = $pengajuan->user->email ?? null;
        if (!$userEmail) {
            return back()->with('error', 'User tidak memiliki email terdaftar.');
        }

        // Ensure PDF exists; if not, generate it here
        $filename = $pengajuan->file_surat_hasil;
        $fullDirectory = storage_path('app/public/surat_hasil');
        $path = $fullDirectory . DIRECTORY_SEPARATOR . ($filename ?? '');

        if (!$filename || !file_exists($path)) {
            // Generate PDF (similar to generateSurat but without redirect)
            $html = view('pengajuan.pdf', compact('pengajuan'))->render();
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $pengajuan->nomor_pengajuan) . '.pdf';

            try {
                // Ensure directory exists
                if (!is_dir($fullDirectory)) {
                    mkdir($fullDirectory, 0755, true);
                }

                // Generate PDF content
                $pdfContent = null;
                if (class_exists(\Barryvdh\DomPDF\Facade::class)) {
                    $pdf = \PDF::loadHTML($html)->setPaper('a4', 'portrait');
                    $pdfContent = $pdf->output();
                } else {
                    $dompdf = new \Dompdf\Dompdf();
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper('A4', 'portrait');
                    $dompdf->render();
                    $pdfContent = $dompdf->output();
                }

                // Store to disk
                $diskPath = $fullDirectory . DIRECTORY_SEPARATOR . $filename;
                file_put_contents($diskPath, $pdfContent);

                if (!file_exists($diskPath)) {
                    throw new \Exception('File PDF gagal disimpan ke disk di: ' . $diskPath);
                }

                $pengajuan->update([
                    'file_surat_hasil' => $filename,
                    'status' => 'Selesai',
                    'tanggal_selesai' => now()
                ]);

                Log::info('PDF generated successfully in sendPdf: ' . $diskPath);
            } catch (\Throwable $e) {
                Log::error('Generate surat (from sendPdf) failed: ' . $e->getMessage());
                return back()->with('error', 'Gagal generate PDF: ' . $e->getMessage());
            }
        }

        // Send email with attachment
        try {
            Mail::to($userEmail)->send(new PengajuanHasilMail($pengajuan->fresh()));
            return back()->with('success', 'Surat hasil berhasil dikirim ke ' . $userEmail);
        } catch (\Throwable $e) {
            Log::error('Send surat email failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
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
                        $data = $pengajuan->data_tambahan ?? [];
                        $data['ts_diproses'] = now()->toDateTimeString();
                        $pengajuan->update([
                            'status' => 'Diproses',
                            'diproses_oleh' => Auth::id(),
                            'data_tambahan' => $data
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

    /**
     * Show download history for all pengajuan
     */
    public function showDownloadHistory()
    {
        $histories = DownloadHistory::with(['pengajuan', 'user'])
            ->latest()
            ->paginate(20);

        $totalDownloads = DownloadHistory::count();

        return view('admin.pengajuan.download-history', compact('histories', 'totalDownloads'));
    }
}
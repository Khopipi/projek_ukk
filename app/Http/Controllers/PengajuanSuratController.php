<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
    public function create(Request $request)
    {
        $jenisSurat = [
            'Surat Nikah',
            'Surat Tanah',
            'Surat Warisan',
            'Surat Domisili',
            'Surat Akta Kelahiran',
            'Surat Keterangan Tidak Mampu',
            'Surat Akta Kematian'
        ];

        // Ambil data user yang sedang login
        $user = Auth::user();
        
        // Ambil parameter jenis_surat dari URL jika ada
        $jenisSuratParam = $request->query('jenis_surat');

        return view('user.pengajuan.create', compact('jenisSurat', 'user', 'jenisSuratParam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Surat Nikah,Surat Tanah,Surat Warisan,Surat Domisili,Surat Akta Kelahiran,Surat Keterangan Tidak Mampu,Surat Akta Kematian',
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
            // Textual fields per jenis surat
            'nama_calon_pria' => 'required_if:jenis_surat,Surat Nikah|nullable|string|max:255',
            'nama_calon_wanita' => 'required_if:jenis_surat,Surat Nikah|nullable|string|max:255',
            'tanggal_nikah_rencana' => 'required_if:jenis_surat,Surat Nikah|nullable|date',
            'tempat_nikah' => 'required_if:jenis_surat,Surat Nikah|nullable|string|max:255',
            'alamat_tanah' => 'required_if:jenis_surat,Surat Tanah|nullable|string',
            'luas_tanah' => 'required_if:jenis_surat,Surat Tanah|nullable|numeric',
            'nama_almarhum' => 'required_if:jenis_surat,Surat Warisan,Surat Akta Kematian|nullable|string|max:255',
            'hubungan_almarhum' => 'required_if:jenis_surat,Surat Warisan|nullable|string|max:255',
            'daftar_penerima' => 'required_if:jenis_surat,Surat Warisan|nullable|string',
            'asal_desa' => 'required_if:jenis_surat,Surat Domisili|nullable|string|max:255',
            'asal_kota' => 'required_if:jenis_surat,Surat Domisili|nullable|string|max:255',
            'tujuan_desa' => 'required_if:jenis_surat,Surat Domisili|nullable|string|max:255',
            'tujuan_kota' => 'required_if:jenis_surat,Surat Domisili|nullable|string|max:255',
            'alamat_domisili' => 'required_if:jenis_surat,Surat Domisili|nullable|string',
            'rt_rw' => 'required_if:jenis_surat,Surat Domisili|nullable|string|max:20',
            'nama_ayah' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|string|max:255',
            'nama_ibu' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|string|max:255',
            'nama_bayi' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|string|max:255',
            'tanggal_lahir_bayi' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|date',
            'tempat_lahir_bayi' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|string|max:255',
            'jenis_kelamin_bayi' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|in:Laki-laki,Perempuan',
            'tempat_lahir_almarhum' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|string|max:255',
            'tanggal_lahir_almarhum' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|date',
            'tempat_makam' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|string|max:255',
            'keterangan_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|string',
            // Dokumen khusus per jenis surat
            'doc_ktp_pemohon' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_pemohon' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_npwp' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_pbb' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_girik' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_riwayat_tanah' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Surat Domisili specific documents
            'doc_kk_domisili' => 'required_if:jenis_surat,Surat Domisili|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_domisili' => 'required_if:jenis_surat,Surat Domisili|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_form_f103' => 'required_if:jenis_surat,Surat Domisili|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_kelahiran_domisili' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_nikah_cerai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Surat Warisan specific documents
            'doc_akta_kematian' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_ktp_pewaris' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_pewaris' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_ahli' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_ahli' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_pengantar_rtrw' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_kelahiran_ahli' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_nikah_pewaris' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_rt_rw' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Surat Akta Kematian specific documents
            'doc_surat_keterangan_kematian' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_ktp_almarhum' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_almarhum' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_pelapor' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_kelahiran_almarhum' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Akta Kematian textual fields
            'nama_almarhum' => 'required_if:jenis_surat,Surat Akta Kematian|string|max:255',
            'tempat_lahir_almarhum' => 'required_if:jenis_surat,Surat Akta Kematian|string|max:255',
            'tanggal_lahir_almarhum' => 'required_if:jenis_surat,Surat Akta Kematian|date',
            'tempat_makam' => 'required_if:jenis_surat,Surat Akta Kematian|string|max:255',
            // Surat Keterangan Tidak Mampu specific documents
            'doc_kk_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_pengantar_rtrw_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_pernyataan_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_foto_rumah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_bukti_penghasilan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'data_tambahan' => 'nullable|array'
        ]);

        // Ensure data_tambahan array exists
        if (!isset($validated['data_tambahan']) || !is_array($validated['data_tambahan'])) {
            $validated['data_tambahan'] = [];
        }

        // Capture all textual fields from request and store in data_tambahan
        $textualFields = [
            // Surat Nikah
            'nama_calon_pria',
            'nama_calon_wanita',
            'tanggal_nikah_rencana',
            'tempat_nikah',
            // Surat Tanah
            'alamat_tanah',
            'luas_tanah',
            // Surat Warisan
            'nama_almarhum',
            'hubungan_almarhum',
            'daftar_penerima',
            // Surat Domisili
            'asal_desa',
            'asal_kota',
            'tujuan_desa',
            'tujuan_kota',
            'alamat_domisili',
            'rt_rw',
            // Surat Akta Kelahiran
            'nama_ayah',
            'nama_ibu',
            'nama_bayi',
            'tanggal_lahir_bayi',
            'tempat_lahir_bayi',
            'jenis_kelamin_bayi',
            // Surat Akta Kematian
            'tempat_lahir_almarhum',
            'tanggal_lahir_almarhum',
            'tempat_makam',
            // Surat Keterangan Tidak Mampu
            'keterangan_tidak_mampu',
        ];

        foreach ($textualFields as $field) {
            if ($request->filled($field)) {
                $validated['data_tambahan'][$field] = $request->input($field);
            }
        }

        // Map jenis_surat to a DB-safe value if the database still uses an ENUM
        // that doesn't include newly added types. We store the original value
        // inside `data_tambahan` under 'jenis_surat_asli' so admin/views can
        // show the real requested type.
        $dbAllowed = [
            'Surat Nikah',
            'Pembuatan KTP',
            'Surat Tanah',
            'Surat Warisan',
            'Surat Domisili',
            'Surat Akta Kelahiran',
            'Surat Kelahiran',
            'Surat Keterangan Tidak Mampu'
        ];
        $originalJenis = $validated['jenis_surat'] ?? null;
        if ($originalJenis && !in_array($originalJenis, $dbAllowed)) {
            $validated['data_tambahan']['jenis_surat_asli'] = $originalJenis;
            // Use a safe fallback for DB insert
            $validated['jenis_surat'] = 'Surat Keterangan Tidak Mampu';
        }

        $validated['user_id'] = Auth::id();

        // Ensure pengajuan directory exists
        $storageDir = storage_path('app/public/pengajuan');
        if (!file_exists($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        // Handle file uploads
        if ($request->hasFile('file_ktp')) {
            $file = $request->file('file_ktp');
            $filename = time() . '_ktp_' . str_replace(' ', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('pengajuan', $file, $filename);
            $validated['file_ktp'] = $filename;
        }

        if ($request->hasFile('file_kk')) {
            $file = $request->file('file_kk');
            $filename = time() . '_kk_' . str_replace(' ', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('pengajuan', $file, $filename);
            $validated['file_kk'] = $filename;
        }

        // Handle optional files
        for ($i = 1; $i <= 3; $i++) {
            $fieldName = "file_pendukung_{$i}";
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $filename = time() . "_pendukung{$i}_" . str_replace(' ', '_', $file->getClientOriginalName());
                Storage::disk('public')->putFileAs('pengajuan', $file, $filename);
                $validated[$fieldName] = $filename;
            }
        }

        // Handle doc_* fields and store them into data_tambahan array
        $docFields = [
            // Surat Nikah specific (13 docs)
            'doc_surat_pengantar_rtrw',
            'doc_surat_pengantar_kelurahan',
            'doc_formulir_n1',
            'doc_formulir_n2',
            'doc_formulir_n4',
            'doc_ktp_pria',
            'doc_ktp_wanita',
            'doc_kk_pria',
            'doc_kk_wanita',
            'doc_akta_lahir_pria',
            'doc_akta_lahir_wanita',
            'doc_pas_foto_pria',
            'doc_pas_foto_wanita',
            // Surat Tanah specific (6 docs)
            'doc_ktp_pemohon',
            'doc_kk_pemohon',
            'doc_npwp',
            'doc_pbb',
            'doc_girik',
            'doc_riwayat_tanah',
            // Surat Warisan specific (8 docs)
            'doc_akta_kematian',
            'doc_ktp_pewaris',
            'doc_kk_pewaris',
            'doc_ktp_ahli',
            'doc_kk_ahli',
            'doc_akta_kelahiran_ahli',
            'doc_surat_nikah_pewaris',
            // Surat Domisili specific (5 docs)
            'doc_kk_domisili',
            'doc_ktp_domisili',
            'doc_form_f103',
            'doc_akta_kelahiran_domisili',
            'doc_surat_nikah_cerai',
            // Surat Akta Kelahiran specific (5 docs)
            'doc_surat_keterangan_lahir',
            'doc_akta_nikah_orangtua',
            'doc_kk_kelahiran',
            'doc_ktp_ayah',
            'doc_ktp_ibu',
            // Surat Akta Kematian specific (5 docs)
            'doc_surat_keterangan_kematian',
            'doc_ktp_almarhum',
            'doc_kk_almarhum',
            'doc_ktp_pelapor',
            'doc_akta_kelahiran_almarhum',
            // Surat Keterangan Tidak Mampu specific (5 docs)
            'doc_kk_tidak_mampu',
            'doc_ktp_tidak_mampu',
            'doc_pengantar_rtrw_tidak_mampu',
            'doc_pernyataan_tidak_mampu',
            'doc_foto_rumah',
            // Other/legacy docs
            'doc_bukti_penghasilan',
            'doc_rt_rw',
            'doc_surat_kelahiran'
        ];
        if (!isset($validated['data_tambahan']) || !is_array($validated['data_tambahan'])) {
            $validated['data_tambahan'] = [];
        }

        foreach ($docFields as $doc) {
            if ($request->hasFile($doc)) {
                $file = $request->file($doc);
                $filename = time() . '_' . $doc . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                Storage::disk('public')->putFileAs('pengajuan', $file, $filename);
                $validated['data_tambahan'][$doc] = $filename;
            }
        }

        // Store submission timestamp (dikirim)
        if (!isset($validated['data_tambahan']) || !is_array($validated['data_tambahan'])) {
            $validated['data_tambahan'] = [];
        }
        // Only set ts_dikirim if not already present
        if (empty($validated['data_tambahan']['ts_dikirim'])) {
            $validated['data_tambahan']['ts_dikirim'] = now()->toDateTimeString();
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
            'Surat Tanah',
            'Surat Warisan',
            'Surat Domisili',
            'Surat Akta Kelahiran',
            'Surat Keterangan Tidak Mampu',
            'Surat Akta Kematian'
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
            'jenis_surat' => 'required|in:Surat Nikah,Surat Tanah,Surat Warisan,Surat Domisili,Surat Akta Kelahiran,Surat Keterangan Tidak Mampu,Surat Akta Kematian',
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
            // Dokumen khusus per jenis surat
            'doc_ktp_pemohon' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_pemohon' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_npwp' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_pbb' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_girik' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_riwayat_tanah' => 'required_if:jenis_surat,Surat Tanah|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Surat Domisili specific documents
            'doc_kk_domisili' => 'required_if:jenis_surat,Surat Domisili|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_domisili' => 'required_if:jenis_surat,Surat Domisili|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_form_f103' => 'required_if:jenis_surat,Surat Domisili|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_kelahiran_domisili' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_nikah_cerai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            // Surat Warisan specific documents
            'doc_akta_kematian' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_ktp_pewaris' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_pewaris' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_ahli' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_ahli' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_pengantar_rtrw' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_kelahiran_ahli' => 'required_if:jenis_surat,Surat Warisan|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_nikah_pewaris' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            // Surat Akta Kelahiran specific documents
            'doc_surat_keterangan_lahir' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_nikah_orangtua' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_kelahiran' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_ayah' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_ibu' => 'required_if:jenis_surat,Surat Akta Kelahiran|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_rt_rw' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_surat_kelahiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Surat Akta Kematian specific documents (for update)
            'doc_surat_keterangan_kematian' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'doc_ktp_almarhum' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_kk_almarhum' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_pelapor' => 'required_if:jenis_surat,Surat Akta Kematian|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_akta_kelahiran_almarhum' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            // Surat Keterangan Tidak Mampu specific documents
            'doc_kk_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_ktp_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_pengantar_rtrw_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_pernyataan_tidak_mampu' => 'required_if:jenis_surat,Surat Keterangan Tidak Mampu|nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_foto_rumah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'doc_bukti_penghasilan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'data_tambahan' => 'nullable|array'
        ]);

        // If jenis_surat in update is a value not present in the DB ENUM,
        // store the original value in data_tambahan and use a safe fallback
        // so the update doesn't fail. This mirrors the behavior in store().
        if (!isset($validated['data_tambahan']) || !is_array($validated['data_tambahan'])) {
            $validated['data_tambahan'] = $pengajuan->data_tambahan ?? [];
        }
        $dbAllowed = [
            'Surat Nikah',
            'Pembuatan KTP',
            'Surat Tanah',
            'Surat Warisan',
            'Surat Domisili',
            'Surat Akta Kelahiran',
            'Surat Kelahiran',
            'Surat Keterangan Tidak Mampu'
        ];
        $originalJenis = $validated['jenis_surat'] ?? null;
        if ($originalJenis && !in_array($originalJenis, $dbAllowed)) {
            $validated['data_tambahan']['jenis_surat_asli'] = $originalJenis;
            $validated['jenis_surat'] = 'Surat Keterangan Tidak Mampu';
        }

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

        // Handle doc_* fields in data_tambahan and delete old docs if replaced
        $docFields = [
            // Surat Nikah specific (13 docs)
            'doc_surat_pengantar_rtrw',
            'doc_surat_pengantar_kelurahan',
            'doc_formulir_n1',
            'doc_formulir_n2',
            'doc_formulir_n4',
            'doc_ktp_pria',
            'doc_ktp_wanita',
            'doc_kk_pria',
            'doc_kk_wanita',
            'doc_akta_lahir_pria',
            'doc_akta_lahir_wanita',
            'doc_pas_foto_pria',
            'doc_pas_foto_wanita',
            // Surat Tanah specific (6 docs)
            'doc_ktp_pemohon',
            'doc_kk_pemohon',
            'doc_npwp',
            'doc_pbb',
            'doc_girik',
            'doc_riwayat_tanah',
            // Surat Warisan specific (8 docs)
            'doc_akta_kematian',
            'doc_ktp_pewaris',
            'doc_kk_pewaris',
            'doc_ktp_ahli',
            'doc_kk_ahli',
            'doc_akta_kelahiran_ahli',
            'doc_surat_nikah_pewaris',
            // Surat Domisili specific (5 docs)
            'doc_kk_domisili',
            'doc_ktp_domisili',
            'doc_form_f103',
            'doc_akta_kelahiran_domisili',
            'doc_surat_nikah_cerai',
            // Surat Akta Kelahiran specific (5 docs)
            'doc_surat_keterangan_lahir',
            'doc_akta_nikah_orangtua',
            'doc_kk_kelahiran',
            'doc_ktp_ayah',
            'doc_ktp_ibu',
            // Surat Keterangan Tidak Mampu specific (5 docs)
            'doc_kk_tidak_mampu',
            'doc_ktp_tidak_mampu',
            'doc_pengantar_rtrw_tidak_mampu',
            'doc_pernyataan_tidak_mampu',
            'doc_foto_rumah',
            // Other/legacy docs
            'doc_bukti_penghasilan',
            'doc_rt_rw',
            'doc_surat_kelahiran'
        ];
        if (!isset($validated['data_tambahan']) || !is_array($validated['data_tambahan'])) {
            $validated['data_tambahan'] = $pengajuan->data_tambahan ?? [];
        }

        foreach ($docFields as $doc) {
            if ($request->hasFile($doc)) {
                // delete old file if exists in data_tambahan
                $oldFile = $pengajuan->data_tambahan[$doc] ?? null;
                if ($oldFile) {
                    Storage::delete('public/pengajuan/' . $oldFile);
                }
                $file = $request->file($doc);
                $filename = time() . '_' . $doc . '_' . $file->getClientOriginalName();
                $file->storeAs('public/pengajuan', $filename);
                $validated['data_tambahan'][$doc] = $filename;
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

    /**
     * Serve file from pengajuan storage
     */
    public function file($filename)
    {
        $filePath = 'pengajuan/' . $filename;

        // Check if file exists in storage
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found');
        }

        $fullPath = storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'public', 'pengajuan', $filename]));
        if (!file_exists($fullPath)) abort(404, 'File not found');

        return response()->file($fullPath);
    }

    /**
     * Serve surat_hasil PDF files with authorization check.
     */
    public function fileSuratHasil($filename)
    {
        $filePath = 'surat_hasil/' . $filename;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found');
        }

        // Find pengajuan that matches this file
        $pengajuan = PengajuanSurat::where('file_surat_hasil', $filename)->first();
        if (!$pengajuan) {
            abort(404, 'File tidak terkait pengajuan manapun');
        }

        // Authorization: pemilik pengajuan atau admin boleh mengakses
        $user = Auth::user();
        if ($user->id !== $pengajuan->user_id && $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $fullPath = storage_path(implode(DIRECTORY_SEPARATOR, ['app', 'public', 'surat_hasil', $filename]));
        if (!file_exists($fullPath)) abort(404, 'File not found');

        return response()->file($fullPath);
    }
}
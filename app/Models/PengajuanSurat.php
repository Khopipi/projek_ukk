<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pengajuan',
        'user_id',
        'jenis_surat',
        'keperluan',
        'nama_pemohon',
        'nik_pemohon',
        'tempat_lahir_pemohon',
        'tanggal_lahir_pemohon',
        'jenis_kelamin_pemohon',
        'pekerjaan_pemohon',
        'alamat_pemohon',
        'no_telepon_pemohon',
        'data_tambahan',
        'file_ktp',
        'file_kk',
        'file_pendukung_1',
        'file_pendukung_2',
        'file_pendukung_3',
        'status',
        'catatan_admin',
        'tanggal_disetujui',
        'tanggal_ditolak',
        'tanggal_selesai',
        'diproses_oleh',
        'file_surat_hasil',
        'signature_token',
        'signature_generated_at'
    ];

    protected $casts = [
        'tanggal_lahir_pemohon' => 'date',
        'tanggal_disetujui' => 'datetime',
        'tanggal_ditolak' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'signature_generated_at' => 'datetime',
        'data_tambahan' => 'array'
    ];

    /**
     * Relasi ke User (Pemohon)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Admin yang memproses
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    /**
     * Relasi ke Download History
     */
    public function downloadHistories()
    {
        return $this->hasMany(DownloadHistory::class, 'pengajuan_surat_id');
    }

    /**
     * Generate nomor pengajuan otomatis
     */
    public static function generateNomorPengajuan()
    {
        $prefix = 'SRT';
        $date = date('Ymd');
        $lastNumber = self::whereDate('created_at', today())
            ->count() + 1;
        
        return $prefix . '/' . $date . '/' . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate nomor pengajuan saat membuat record baru
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_pengajuan)) {
                $model->nomor_pengajuan = self::generateNomorPengajuan();
            }
            
            // Auto-generate QR code token saat membuat pengajuan baru
            if (empty($model->signature_token)) {
                try {
                    // Generate token yang akan di-encode ke QR SVG
                    $userId = auth()?->id() ?? 1;
                    $model->signature_token = \App\Helpers\QrCodeGenerator::generateSignatureToken($model->id ?? time(), $userId);
                    $model->signature_generated_at = now();
                } catch (\Exception $e) {
                    // Silent fail - akan di-generate saat akses
                }
            }
        });

        // Note: QR SVG di-generate on-demand di component, tidak perlu disimpan ke file
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Menunggu' => 'bg-warning',
            'Diproses' => 'bg-info',
            'Disetujui' => 'bg-success',
            'Ditolak' => 'bg-danger',
            'Selesai' => 'bg-primary',
            default => 'bg-secondary'
        };
    }

    /**
     * Get jenis surat icon
     */
    public function getJenisSuratIconAttribute()
    {
        return match($this->jenis_surat) {
            'Surat Nikah' => 'ti ti-heart',
            'Surat Tanah' => 'ti ti-map',
            'Surat Warisan' => 'ti ti-building-estate',
            'Surat Domisili' => 'ti ti-home',
            'Surat Akta Kelahiran' => 'ti ti-baby-carriage',
            'Surat Keterangan Tidak Mampu' => 'ti ti-cash-off',
            default => 'ti ti-file'
        };
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan jenis surat
     */
    public function scopeJenisSurat($query, $jenis)
    {
        return $query->where('jenis_surat', $jenis);
    }

    /**
     * Get file URL
     */
    public function getFileKtpUrlAttribute()
    {
        return $this->file_ktp ? route('pengajuan.file', $this->file_ktp) : null;
    }

    public function getFileKkUrlAttribute()
    {
        return $this->file_kk ? route('pengajuan.file', $this->file_kk) : null;
    }

    public function getFileSuratHasilUrlAttribute()
    {
        return $this->file_surat_hasil ? asset('storage/surat_hasil/' . $this->file_surat_hasil) : null;
    }

    /**
     * Get file pendukung URLs
     */
    public function getFilePendukung1UrlAttribute()
    {
        return $this->file_pendukung_1 ? route('pengajuan.file', $this->file_pendukung_1) : null;
    }

    public function getFilePendukung2UrlAttribute()
    {
        return $this->file_pendukung_2 ? route('pengajuan.file', $this->file_pendukung_2) : null;
    }

    public function getFilePendukung3UrlAttribute()
    {
        return $this->file_pendukung_3 ? route('pengajuan.file', $this->file_pendukung_3) : null;
    }

    /**
     * Get special document URL from data_tambahan
     */
    public function getSpecialDocUrl($docField)
    {
        if (!$this->data_tambahan || !is_array($this->data_tambahan)) {
            return null;
        }
        
        $filename = $this->data_tambahan[$docField] ?? null;
        return $filename ? route('pengajuan.file', $filename) : null;
    }

    /**
     * Get all special documents with labels based on jenis_surat
     */
    public function getSpecialDocuments()
    {
        $docs = [];
        
        if (!$this->data_tambahan || !is_array($this->data_tambahan)) {
            return $docs;
        }

        // Order documents by jenis_surat and return only those for current type
        $docsByType = [
            'Surat Nikah' => [
                'doc_surat_pengantar_rtrw' => 'Surat Pengantar dari RT/RW',
                'doc_surat_pengantar_kelurahan' => 'Surat Pengantar dari Kelurahan',
                'doc_formulir_n1' => 'Formulir N1 (Permohonan Pencatatan Perkawinan)',
                'doc_formulir_n2' => 'Formulir N2 (Pernyataan Calon Pengantin)',
                'doc_formulir_n4' => 'Formulir N4 (Daftar Riwayat Hidup)',
                'doc_ktp_pria' => 'Foto/Scan KTP Calon Pengantin Pria',
                'doc_ktp_wanita' => 'Foto/Scan KTP Calon Pengantin Wanita',
                'doc_kk_pria' => 'Kartu Keluarga (KK) Calon Pria',
                'doc_kk_wanita' => 'Kartu Keluarga (KK) Calon Wanita',
                'doc_akta_lahir_pria' => 'Akta Kelahiran Calon Pria',
                'doc_akta_lahir_wanita' => 'Akta Kelahiran Calon Wanita',
                'doc_pas_foto_pria' => 'Pas Foto Calon Pengantin Pria (4x6)',
                'doc_pas_foto_wanita' => 'Pas Foto Calon Pengantin Wanita (4x6)',
            ],
            'Surat Tanah' => [
                'doc_ktp_pemohon' => 'Fotokopi KTP Pemohon',
                'doc_kk_pemohon' => 'Fotokopi Kartu Keluarga (KK) Pemohon',
                'doc_npwp' => 'Fotokopi NPWP',
                'doc_pbb' => 'Bukti Pembayaran PBB Tahun Terakhir',
                'doc_girik' => 'Girik/Letter C/Petok D',
                'doc_riwayat_tanah' => 'Surat Riwayat Tanah',
            ],
            'Surat Warisan' => [
                'doc_akta_kematian' => 'Akta Kematian Pewaris',
                'doc_ktp_pewaris' => 'KTP Pewaris',
                'doc_kk_pewaris' => 'KK Pewaris',
                'doc_ktp_ahli' => 'KTP Ahli Waris',
                'doc_kk_ahli' => 'KK Ahli Waris',
                'doc_surat_pengantar_rtrw' => 'Surat Pengantar RT/RW',
                'doc_akta_kelahiran_ahli' => 'Akta Kelahiran Ahli Waris',
                'doc_surat_nikah_pewaris' => 'Surat Nikah Pewaris (jika ada)',
            ],
            'Surat Domisili' => [
                'doc_kk_domisili' => 'Kartu Keluarga (KK)',
                'doc_ktp_domisili' => 'KTP Asli Pemohon (verifikasi)',
                'doc_form_f103' => 'Formulir Permohonan F-1.03 (Disdukcapil)',
                'doc_akta_kelahiran_domisili' => 'Akta Kelahiran (jika belum punya KTP)',
                'doc_surat_nikah_cerai' => 'Surat Nikah / Cerai (jika ada)',
            ],
            'Surat Akta Kelahiran' => [
                'doc_surat_keterangan_lahir' => 'Surat Keterangan Lahir',
                'doc_akta_nikah_orangtua' => 'Akta Nikah Orang Tua',
                'doc_kk_kelahiran' => 'Kartu Keluarga (KK)',
                'doc_ktp_ayah' => 'KTP Ayah',
                'doc_ktp_ibu' => 'KTP Ibu',
            ],
            'Surat Akta Kematian' => [
                'doc_surat_keterangan_kematian' => 'Surat Keterangan Kematian (asli dari dokter / Puskesmas / Rumah Sakit)',
                'doc_ktp_almarhum' => 'Kartu Tanda Penduduk (KTP) Almarhum / Almarhumah (asli atau fotokopi)',
                'doc_kk_almarhum' => 'Kartu Keluarga (KK) Almarhum / Almarhumah (asli atau fotokopi)',
                'doc_ktp_pelapor' => 'Foto/Scan KTP Pelapor (anak kandung / ahli waris / Ketua RT/RW)',
                'doc_akta_kelahiran_almarhum' => 'Akta Kelahiran Almarhum / Almarhumah (jika belum memiliki KTP)'
            ],
            'Surat Keterangan Tidak Mampu' => [
                'doc_kk_tidak_mampu' => 'Kartu Keluarga (KK)',
                'doc_ktp_tidak_mampu' => 'Kartu Tanda Penduduk (KTP) Asli dan/atau Fotokopi',
                'doc_pengantar_rtrw_tidak_mampu' => 'Surat Pengantar dari RT/RW',
                'doc_pernyataan_tidak_mampu' => 'Surat Pernyataan Tidak Mampu Bermeterai',
                'doc_foto_rumah' => 'Foto Rumah (Jika Diperlukan)',
            ],
        ];

        // Determine which jenis_surat to use for label mapping.
        // If controller saved the original requested jenis under data_tambahan['jenis_surat_asli'], prefer it.
        $requestedJenis = $this->data_tambahan['jenis_surat_asli'] ?? $this->jenis_surat;

        // Try direct match first, then a case-insensitive match to support label variants
        $docLabels = $docsByType[$requestedJenis] ?? null;
        if (!$docLabels) {
            foreach ($docsByType as $typeKey => $labels) {
                if (strcasecmp($typeKey, $requestedJenis) === 0) {
                    $docLabels = $labels;
                    break;
                }
            }
        }
        $docLabels = $docLabels ?? [];

        // Build docs array in order from mapping first
        foreach ($docLabels as $fieldName => $label) {
            if (isset($this->data_tambahan[$fieldName]) && $this->data_tambahan[$fieldName]) {
                $filename = $this->data_tambahan[$fieldName];
                $docs[$fieldName] = [
                    'label' => $label,
                    'filename' => $filename,
                    'url' => route('pengajuan.file', $filename)
                ];
            }
        }

        // Also include any other doc_* fields that exist in data_tambahan but weren't in the mapping
        foreach ($this->data_tambahan as $fieldName => $filename) {
            if (!is_string($fieldName) || strpos($fieldName, 'doc_') !== 0) continue;
            if (!$filename) continue;
            if (isset($docs[$fieldName])) continue; // already included

            // Derive a readable label if not available in mapping
            $label = $docLabels[$fieldName] ?? ucwords(str_replace(['doc_', '_'], ['', ' '], $fieldName));
            $docs[$fieldName] = [
                'label' => $label,
                'filename' => $filename,
                'url' => route('pengajuan.file', $filename)
            ];
        }

        return $docs;
    }

    /**
     * Ensure QR code is generated - if token doesn't exist, generate it
     * Safe to call multiple times (idempotent)
     */
    public function ensureQrCode()
    {
        if (empty($this->signature_token)) {
            try {
                $userId = auth()?->id() ?? $this->user_id ?? 1;
                $this->signature_token = \App\Helpers\QrCodeGenerator::generateSignatureToken($this->id, $userId);
                $this->signature_generated_at = now();
                $this->save();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        return false; // Already exists
    }

    /**
     * Get QR code SVG as base64 data URI
     * Deprecated: Use qr-code-section component instead
     * This method is kept for backward compatibility only
     */
    public function getQrCodePath()
    {
        // Ensure token exists first
        if (empty($this->signature_token)) {
            $this->ensureQrCode();
        }

        if ($this->signature_token) {
            try {
                $qrUrl = \App\Helpers\QrCodeGenerator::generateQrUrl($this->signature_token);
                return \App\Helpers\QrCodeGenerator::generateSvgBase64($qrUrl);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}

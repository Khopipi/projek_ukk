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
        'file_surat_hasil'
    ];

    protected $casts = [
        'tanggal_lahir_pemohon' => 'date',
        'tanggal_disetujui' => 'datetime',
        'tanggal_ditolak' => 'datetime',
        'tanggal_selesai' => 'datetime',
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
        });
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
            'Pembuatan KTP' => 'ti ti-id',
            'Surat Tanah' => 'ti ti-map',
            'Surat Warisan' => 'ti ti-building-estate',
            'Surat Domisili' => 'ti ti-home',
            'Surat Kelahiran' => 'ti ti-baby-carriage',
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
        return $this->file_ktp ? asset('storage/pengajuan/' . $this->file_ktp) : null;
    }

    public function getFileKkUrlAttribute()
    {
        return $this->file_kk ? asset('storage/pengajuan/' . $this->file_kk) : null;
    }

    public function getFileSuratHasilUrlAttribute()
    {
        return $this->file_surat_hasil ? asset('storage/surat_hasil/' . $this->file_surat_hasil) : null;
    }
}
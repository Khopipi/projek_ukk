<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_pengaduan',
        'user_id',
        'kategori',
        'judul',
        'isi_pengaduan',
        'lokasi',
        'foto_1',
        'foto_2',
        'foto_3',
        'status',
        'prioritas',
        'tanggapan_admin',
        'ditanggapi_oleh',
        'tanggal_ditanggapi',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_ditanggapi' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Relasi ke User (Pelapor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Admin yang menanggapi
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'ditanggapi_oleh');
    }

    /**
     * Generate nomor pengaduan otomatis
     */
    public static function generateNomorPengaduan()
    {
        $prefix = 'ADU';
        $date = date('Ymd');
        $lastNumber = self::whereDate('created_at', today())->count() + 1;

        return $prefix . '/' . $date . '/' . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate nomor pengaduan saat membuat record baru
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomor_pengaduan)) {
                $model->nomor_pengaduan = self::generateNomorPengaduan();
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
            'Selesai' => 'bg-success',
            'Ditolak' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get prioritas badge color
     */
    public function getPrioritasBadgeAttribute()
    {
        return match($this->prioritas) {
            'Rendah' => 'bg-secondary',
            'Sedang' => 'bg-info',
            'Tinggi' => 'bg-warning',
            'Mendesak' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get kategori icon
     */
    public function getKategoriIconAttribute()
    {
        return match($this->kategori) {
            'Infrastruktur' => 'ti ti-road',
            'Kebersihan' => 'ti ti-trash',
            'Keamanan' => 'ti ti-shield',
            'Pelayanan Publik' => 'ti ti-users',
            'Kesehatan' => 'ti ti-heart',
            'Pendidikan' => 'ti ti-book',
            'Lainnya' => 'ti ti-dots',
            default => 'ti ti-alert-circle'
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
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Get foto URL
     */
    public function getFoto1UrlAttribute()
    {
        if (!$this->foto_1) return null;
        return asset('storage/pengaduan/' . $this->foto_1);
    }

    public function getFoto2UrlAttribute()
    {
        if (!$this->foto_2) return null;
        return asset('storage/pengaduan/' . $this->foto_2);
    }

    public function getFoto3UrlAttribute()
    {
        if (!$this->foto_3) return null;
        return asset('storage/pengaduan/' . $this->foto_3);
    }
}

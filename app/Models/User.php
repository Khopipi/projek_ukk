<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'provider',
        'provider_id',
        'is_verified',
        'otp_code',
        'otp_expires_at',
        // Data Pribadi
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        // Data Alamat
        'alamat',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        // Data Lainnya
        'no_kk',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'pendidikan_terakhir',
        'no_telepon',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'tanggal_lahir' => 'date',
            'password' => 'hashed',
        ];
    }

    public function pengajuanSurat()
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    // Accessor untuk mendapatkan umur
    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) return null;
        return $this->tanggal_lahir->age;
    }

    // Accessor untuk alamat lengkap
    public function getAlamatLengkapAttribute()
    {
        $parts = array_filter([
            $this->alamat,
            $this->rt ? "RT {$this->rt}" : null,
            $this->rw ? "RW {$this->rw}" : null,
            $this->desa,
            $this->kecamatan,
            $this->kabupaten,
            $this->provinsi,
            $this->kode_pos,
        ]);

        return implode(', ', $parts);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penduduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'pendidikan_terakhir',
        'nama_ayah',
        'nama_ibu',
        'status_dalam_keluarga',
        'status_kependudukan',
        'no_telepon',
        'email',
        'foto',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get umur penduduk
     */
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/penduduk/' . $this->foto);
        }
        return asset('assets/images/user/avatar-1.jpg');
    }
}
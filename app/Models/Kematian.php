<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kematian extends Model
{
    protected $fillable = [
        'penduduk_id',
        'nama_warga',
        'tanggal_kematian',
        'penyebab_kematian',
        'tempat_kematian',
        'rs_atau_rumah',
        'usia_saat_meninggal',
        'nama_diperiksa_oleh',
        'keterangan',
        'input_oleh',
    ];

    protected $casts = [
        'tanggal_kematian' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }
}


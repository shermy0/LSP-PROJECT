<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfirmasiOrangRelevan extends Model
{
    protected $table = 'konfirmasi_orang_relevan';
    protected $primaryKey = 'id_konfirmasi';
    public $timestamps = false;

    protected $fillable = [
        'id_validasi',
        'nama',
        'jabatan',
        'tgl_konfirmasi',
        'keterangan',
        'skema_id',
    ];

    // Relasi ke Validasi
    public function validasi()
    {
        return $this->belongsTo(ValidasiAsesmen::class, 'id_validasi');
    }

    // Relasi ke Persetujuan
    public function persetujuan()
    {
        return $this->hasOne(KonfirmasiOrangRelevanPersetujuan::class, 'id_konfirmasi');
    }

    // Relasi ke skema
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }
}

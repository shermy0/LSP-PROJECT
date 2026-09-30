<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiAsesmen extends Model
{
    protected $table = 'validasi_asesmen';
    protected $primaryKey = 'id_validasi';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'periode',
        'tgl_validasi',
        'tujuan',
        'konteks',
        'rekomendasi',
        'skema_id',
    ];

    // Relasi ke laporan
    public function laporan()
    {
        return $this->belongsTo(LaporanAsesmen::class, 'id_laporan');
    }

    // Relasi ke konfirmasi
    public function konfirmasiOrangRelevan()
    {
        return $this->hasMany(KonfirmasiOrangRelevan::class, 'id_validasi');
    }

    // Relasi ke skema
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }
}

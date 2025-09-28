<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanAsesmen extends Model
{
    protected $table = 'laporan_asesmen';
    protected $primaryKey = 'id_laporan';
    public $timestamps = false;

    protected $fillable = [
        'id_instrumen',
        'aspek_positif_negatif',
        'penolakan',
        'saran_perbaikan',
        'tgl_laporan',
        'skema_id',
    ];

    // Relasi ke ValidasiAsesmen
    public function validasi()
    {
        return $this->hasMany(ValidasiAsesmen::class, 'id_laporan');
    }

    // Relasi ke Skema
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }
}

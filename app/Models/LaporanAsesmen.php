<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'laporan_asesmen';
    protected $primaryKey = 'id_laporan';
    public $timestamps = false;

    protected $fillable = [
        'id_instrumen',
        'aspek_positif_negatif',
        'penolakan',
        'saran_perbaikan',
        'tgl_laporan',
        'asesor_id',
        'skema_id',
        'no_registrasi',
    ];
    
    public function asesor()
    {
        // relasi ke tabel asesor
        return $this->belongsTo(Asesor::class, 'asesor_id', 'id_asesor');
    }

    public function skema()
    {
        // relasi ke tabel skema_sertifikasi
        return $this->belongsTo(Skema::class, 'skema_id', 'id_skema');
    }
}
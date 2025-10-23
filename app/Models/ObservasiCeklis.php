<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservasiCeklis extends Model
{
    use HasFactory;

    protected $table = 'observasi_ceklis';
    protected $primaryKey = 'id_observasi';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'id_asesor',
        'id_asesi',
        'umpan_balik',
        'rekomendasi',
        'rekomendasi_rincian',
    ];

    // Relasi ke Observasi Item
    public function items()
    {
        return $this->hasMany(ObservasiCeklisItem::class, 'id_observasi', 'id_observasi');
    }

    // Relasi ke Persetujuan
    public function persetujuan()
    {
        return $this->hasOne(ObservasiCeklisPersetujuan::class, 'id_observasi', 'id_observasi');
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
}

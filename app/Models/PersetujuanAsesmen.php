<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanAsesmen extends Model
{
    protected $table = 'persetujuan_asesmen';
    protected $primaryKey = 'id_persetujuan';
    protected $fillable = [
        'id_permohonan',
        'id_asesi',
        'id_asesor',
        'id_skema',
        'id_tuk',
        'hari',
        'tgl_pelaksanaan',
        'waktu',
        'lokasi',
        'pernyataan_kerahasiaan',
        'setuju_asesmen',
        'status'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema');
    }

    public function tuk()
    {
        return $this->belongsTo(Tuk::class, 'id_tuk');
    }

    public function buktiTerpilih()
    {
        return $this->hasMany(PersetujuanAsesmenBukti::class, 'id_persetujuan', 'id_persetujuan');
    }
    
    public function ttd()
    {
        return $this->hasOne(PersetujuanAsesmenPersetujuan::class, 'id_persetujuan');
    }
}
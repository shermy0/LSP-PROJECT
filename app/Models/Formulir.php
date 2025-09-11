<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanAsesmen extends Model
{
    protected $table = 'persetujuan_asesmen';
    protected $primaryKey = 'id_persetujuan'; // sesuaikan dengan PK di DB
    public $timestamps = false;

    // relasi ke asesi
    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    // relasi ke asesor
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    // relasi ke skema
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    // relasi ke TUK
    public function tuk()
    {
        return $this->belongsTo(Tuk::class, 'id_tuk', 'id_tuk');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'rekaman_asesmen';
    protected $primaryKey = 'id_rekaman';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'id_asesor',
        'id_asesi',
        'id_tuk',
        'hasil',
        'tindak_lanjut',
        'komentar_asesor'
    ];

    // Relasi ke hasil rekaman
    public function detailHasil()
    {
       return $this->hasMany(\App\Models\HasilRekamanAsesmen::class, 'id_rekaman');
    }   


    // Relasi ke Asesi
    public function asesi()
    {
        return $this->belongsTo(\App\Models\Asesi::class, 'id_asesi');
    }

    // Relasi ke Asesor (mengambil dari tabel users)
    public function asesor()
    {
        return $this->belongsTo(\App\Models\Asesor::class, 'id_asesor');
    }
}

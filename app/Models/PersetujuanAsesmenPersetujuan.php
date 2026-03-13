<?php
// app/Models/PersetujuanAsesmenPersetujuan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanAsesmenPersetujuan extends Model
{
    protected $table = 'persetujuan_asesmen_persetujuan';
    protected $primaryKey = 'id_persetujuan_ttd';
    public $timestamps = false;

    protected $fillable = [
        'id_persetujuan',
        'tgl_ttd_asesi',
        'ttd_asesi',
        'tgl_ttd_asesor',
        'ttd_asesor',
    ];

    /**
     * Relasi ke PersetujuanAsesmen
     */
    public function persetujuan()
    {
        return $this->belongsTo(PersetujuanAsesmen::class, 'id_persetujuan', 'id_persetujuan');
    }
}
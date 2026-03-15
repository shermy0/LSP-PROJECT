<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanAsesmenPersetujuan extends Model
{
    protected $table = 'jawaban_asesmen_persetujuan';
    protected $primaryKey = 'id_jawaban_persetujuan';
    protected $fillable = [
        'id_jawaban',
        'tgl_ttd_asesi',
        'ttd_asesi',
        'tgl_ttd_asesor',
        'ttd_asesor',
        'umpan_balik',
    ];

    public function jawaban()
    {
        return $this->belongsTo(JawabanAsesmen::class, 'id_jawaban');
    }
}
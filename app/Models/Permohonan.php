<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $table = 'permohonan';
    protected $primaryKey = 'id_permohonan';
    public $timestamps = true;

    protected $fillable = [
        'id_asesi',
        'id_admin',
        'id_skema',
        'tgl_permohonan',
        'tujuan_asesmen',
        'status',
        'catatan'
    ];
}

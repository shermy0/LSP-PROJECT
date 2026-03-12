<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyusun extends Model
{
    protected $table = 'penyusun_persetujuan';
    public $timestamps = false;

    protected $fillable = [
        'id_asesor',
        'id_skema',
        'no_met',
        'tanggal',
        'tanda_tangan',
        'catatan',
    ];
}
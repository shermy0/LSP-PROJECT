<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKompetensi extends Model
{
    protected $table = 'unit_kompetensi';
    protected $primaryKey = 'id_unit';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'kode_unit',
        'judul_unit',
        'standar_kompetensi',
        'deskripsi_unit'
    ];
}

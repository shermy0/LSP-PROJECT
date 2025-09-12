<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkemaSertifikasi extends Model
{
    protected $table = 'skema_sertifikasi';
    protected $primaryKey = 'id_skema';
    protected $fillable = [
        'nama_skema',
        'kode_skema',
        'jenjang',
        'bidang_keahlian',
        'deskripsi',
        'status_skema',
    ];
}


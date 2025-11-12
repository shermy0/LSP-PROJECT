<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesmen extends Model
{
    protected $table = 'asesmen';
    protected $primaryKey = 'id_asesmen';
    public $timestamps = false;
    protected $fillable = [
        'id_permohonan', 'id_jadwal', 'hasil', 'umpan_balik_asesi', 'catatan', 'tgl_asesmen', 'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanAsesmen extends Model
{
    protected $table = 'tujuan_asesmen';
    protected $primaryKey = 'id_tujuan';
    public $timestamps = false;

    protected $fillable = ['nama_tujuan'];

    public function skemas()
    {
        return $this->belongsToMany(
            SkemaSertifikasi::class,
            'skema_tujuan',   // pivot table
            'tujuan_id',      // FK pivot ke tujuan
            'skema_id'        // FK pivot ke skema
        );
    }
}

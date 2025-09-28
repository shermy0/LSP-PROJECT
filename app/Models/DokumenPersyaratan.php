<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    protected $table = 'dokumen_persyaratan';
    protected $primaryKey = 'id_dokumen_persyaratan';
    protected $fillable = [
        'id_permohonan',
        'id_jenis_dokumen',
        'file_path',
        'memenuhi_syarat',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
    }
}

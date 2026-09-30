<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DasarAsesmen extends Model
{
    protected $table = 'dasar_asesmen';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'skema_id',
        'kriteria_asesmen',
        'spesifikasi_kinerja',
        'spesifikasi_produk',
        'pedoman_khusus'
    ];

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id', 'id_skema');
    }
}

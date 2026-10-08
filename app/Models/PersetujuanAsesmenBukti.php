<?php
// app/Models/PersetujuanAsesmenBukti.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanAsesmenBukti extends Model
{
    protected $table = 'persetujuan_asesmen_bukti';
    protected $primaryKey = 'id_bukti';
    public $timestamps = false;

    protected $fillable = [
        'id_persetujuan',
        'id_jenis_bukti',
        'dipilih',
        'deskripsi',
    ];

    /**
     * Relasi ke PersetujuanAsesmen
     */
    public function persetujuan()
    {
        return $this->belongsTo(PersetujuanAsesmen::class, 'id_persetujuan', 'id_persetujuan');
    }

    /**
     * Relasi ke MasterJenisBukti
     */
    public function jenisBukti()
    {
        return $this->belongsTo(MasterJenisBukti::class, 'id_jenis_bukti', 'id_jenis_bukti');
    }
}
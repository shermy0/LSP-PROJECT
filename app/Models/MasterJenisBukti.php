<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJenisBukti extends Model
{
    protected $table = 'master_jenis_bukti';
    protected $primaryKey = 'id_jenis_bukti';
    public $timestamps = false;

    protected $fillable = [
        'nama_bukti',
        // tambahkan kolom lain jika diperlukan, misal 'deskripsi'
    ];

    /**
     * Relasi ke PerangkatAsesmen (opsional, jika masih digunakan)
     */
    public function perangkat()
    {
        return $this->hasMany(PerangkatAsesmen::class, 'id_jenis_bukti');
    }

    /**
     * Relasi ke PersetujuanAsesmenBukti untuk fitur FR.AK.01
     */
    public function persetujuanBukti()
    {
        return $this->hasMany(PersetujuanAsesmenBukti::class, 'id_jenis_bukti', 'id_jenis_bukti');
    }
}
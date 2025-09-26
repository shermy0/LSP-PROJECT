<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    protected $table = 'skema_sertifikasi';
    protected $primaryKey = 'id_skema';
    public $timestamps = true;

    protected $fillable = [
        'nama_skema',
        'kode_skema',
        'jenjang',
        'bidang_keahlian',
        'deskripsi',
        'status_skema',
    ];

    // ================================
    // Relasi: Skema punya banyak KelompokPekerjaan
    // ================================
    public function kelompokPekerjaan()
    {
        return $this->hasMany(KelompokPekerjaan::class, 'id_skema', 'id_skema');
    }
}
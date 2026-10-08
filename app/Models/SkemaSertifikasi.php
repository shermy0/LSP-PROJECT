<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkemaSertifikasi extends Model
{
    protected $table = 'skema_sertifikasi';
    protected $primaryKey = 'id_skema';
    public $timestamps = false;

    protected $fillable = [
        'kode_skema',
        'nama_skema',
        'judul_skema',
        'jenjang',
        'bidang_keahlian',
        'deskripsi',
        'status_skema'
    ];

    public function unitKompetensi()
    {
        return $this->hasMany(UnitKompetensi::class, 'id_skema', 'id_skema');
    }

    public function kelompokPekerjaan()
    {
        return $this->hasMany(KelompokPekerjaan::class, 'id_skema', 'id_skema');
    }

    public function tujuans()
    {
        return $this->belongsToMany(
            TujuanAsesmen::class,
            'skema_tujuan',
            'skema_id',
            'tujuan_id'
        );
    }

    // 🔥 Relasi Many-to-Many ke Asesor (kompatibilitas kode lama)
    public function asesor()
    {
        return $this->belongsToMany(
            Asesor::class,
            'asesor_skema',
            'id_skema',
            'id_asesor'
        );
    }

    /**
     * Relasi many-to-many dengan Asesor (dengan timestamps).
     */
    public function asesors()
    {
        return $this->belongsToMany(
            Asesor::class,
            'asesor_skema',
            'id_skema',
            'id_asesor'
        )->withTimestamps();
    }
}
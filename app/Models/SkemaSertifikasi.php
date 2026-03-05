<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkemaSertifikasi extends Model
{
    protected $table = 'skema_sertifikasi';
    protected $primaryKey = 'id_skema';
    public $timestamps = false; // karena biasanya tabel ini tidak punya created_at & updated_at

    protected $fillable = [
        'kode_skema',
        'nama_skema',
        'jenjang',
        'bidang_keahlian',
        'deskripsi',
        'status_skema'
    ];

    // Relasi ke Unit Kompetensi
    public function unitKompetensi()
    {
        return $this->hasMany(UnitKompetensi::class, 'id_skema', 'id_skema');
    }

    // Relasi ke Kelompok Pekerjaan
    public function kelompokPekerjaan()
    {
        return $this->hasMany(KelompokPekerjaan::class, 'id_skema', 'id_skema');
    }

    // Relasi Many-to-Many ke Tujuan Asesmen lewat pivot skema_tujuan
    public function tujuans()
    {
        return $this->belongsToMany(
            TujuanAsesmen::class,
            'skema_tujuan',
            'skema_id',
            'tujuan_id'
        );
    }

    // 🔥 Relasi Many-to-Many ke Asesor
    public function asesor()
    {
        return $this->belongsToMany(
            Asesor::class,
            'asesor_skema',
            'id_skema',
            'id_asesor'
        );
    }
}

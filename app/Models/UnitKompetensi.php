<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKompetensi extends Model
{
    use HasFactory;

    protected $table = 'unit_kompetensi';   // nama tabel
    protected $primaryKey = 'id_unit';      // primary key sesuai migrasi

    protected $fillable = [
        'id_skema',
        'kode_unit',
        'judul_unit',
        'standar_kompetensi',
        'deskripsi_unit'
    ];

    // relasi ke skema_sertifikasi
    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }
}

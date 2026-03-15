<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMO extends Model
{
    use HasFactory;

    protected $table = 'pmo';
    protected $primaryKey = 'id_pmo'; // ✅ tambah ini
    protected $fillable = [
    'id_skema',
    'id_asesmen',
    'id_tuk', 
    'id_kuk',
    'id_asesor', 
    'id_asesi', 
    'umpan_balik_untuk_asesi',
    'id_unit',
    ];

    public $timestamps = false; // biar ga error created_at / updated_at

    // Relasi ke tabel pertanyaan PMO
    public function pertanyaan()
    {
        // harusnya relasi ke model lain (misal PMOPertanyaan), bukan ke dirinya sendiri
        return $this->hasMany(PMO::class, 'id_pmo');
    }
        public function unit()
    {
        return $this->belongsToMany(UnitKompetensi::class, 'pivot_nama_tabel', 'id_pmo_pertanyaan', 'id_unit');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanPMO extends Model
{
    use HasFactory;

    protected $table      = 'pmo_pertanyaan';
    protected $primaryKey = 'id_pmo_pertanyaan';
    public    $timestamps = false;

    protected $fillable = [
        'id_pmo',
        'id_pembuatan_pertanyaan',
        'id_kelompok',
        'id_unit',
        'pertanyaan',
        'deskripsi_pertanyaan',
    ];

    protected $casts = [
        'id_unit' => 'array', // ✅ otomatis decode JSON jadi array
    ];

    // Relasi ke PMO
    public function pmo()
    {
        return $this->belongsTo(PMO::class, 'id_pmo');
    }

    // Relasi ke KelompokPekerjaan
    public function kelompok()
    {
        return $this->belongsTo(KelompokPekerjaan::class, 'id_kelompok');
    }

    // Relasi ke PembuatanPertanyaan
    public function pembuatan()
    {
        return $this->belongsTo(PembuatanPertanyaan::class, 'id_pembuatan_pertanyaan');
    }
}
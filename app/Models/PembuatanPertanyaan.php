<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembuatanPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pembuatan_pertanyaan';
    protected $primaryKey = 'id_pembuatan_pertanyaan';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'judul',
        'jenis_pertanyaan',
        'timer',
        'aktif',
        'timescap',
    ];

    // Relasi ke tabel skema sertifikasi
    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }

    // Relasi ke tabel pertanyaan (jika ada)
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'id_pembuatan_pertanyaan', 'id_pembuatan_pertanyaan');
    }
}

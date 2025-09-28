<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PembuatanPertanyaan;
use App\Models\KelompokPekerjaan;
use App\Models\OpsiJawaban;
use App\Models\PertanyaanAsesmenPersetujuan;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'id_kelompok',              
        'id_pembuatan_pertanyaan',
        'id_asesor',
        'jenis_pertanyaan',
        'isi_pertanyaan',
        'file_path',
        'file_type',
        'deskripsi_pertanyaan',
        'kunci_jawaban',
    ];

    // Relasi ke tabel pembuatan_pertanyaan
    public function pembuatan()
    {
        return $this->belongsTo(
            PembuatanPertanyaan::class,
            'id_pembuatan_pertanyaan',
            'id_pembuatan_pertanyaan'
        );
    }

    // Relasi ke tabel kelompok
    public function kelompok()
    {
        return $this->belongsTo(KelompokPekerjaan::class, 'id_kelompok', 'id_kelompok');
    }

    // Relasi ke opsi jawaban
    public function opsiJawaban()
    {
        return $this->hasMany(OpsiJawaban::class, 'id_pertanyaan');
    }

    // 🔹 Relasi ke persetujuan asesor (tidak menghapus relasi lain)
    public function persetujuan()
    {
        return $this->hasMany(
            PertanyaanAsesmenPersetujuan::class,
            'id_pembuatan_pertanyaan', // FK di tabel persetujuan
            'id_pembuatan_pertanyaan'  // PK di tabel pertanyaan
        );
    }
}

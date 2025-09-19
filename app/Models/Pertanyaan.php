<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    protected $primaryKey = 'id_pertanyaan';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'id_pembuatan_pertanyaan',
        'id_asesor',
        'jenis_pertanyaan',
        'isi_pertanyaan',
        'file_path',
        'file_type',
        'deskripsi_pertanyaan',
        'kunci_jawaban',
        'id_kelompok'
    ];

    // 🔹 Relasi ke tabel pembuatan_pertanyaan
    public function pembuatan()
    {
        return $this->belongsTo(PembuatanPertanyaan::class, 'id_pembuatan_pertanyaan', 'id_pembuatan_pertanyaan');
    }

        public function kelompok()
    {
        return $this->belongsTo(KelompokPekerjaan::class, 'id_kelompok', 'id_kelompok');
    }

}

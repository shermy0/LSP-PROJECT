<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTugasDemonstrasi extends Model
{
    protected $table = 'master_tugas_demonstrasi';   // nama tabel di DB
    protected $primaryKey = 'id_tugas';              // primary key
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'id_demonstrasi',
        'id_kelompok',
        'nama_tugas',
        'deskripsi_pertanyaan',
        'timescap',
    ];

    // Relasi ke Demonstrasi
    public function demonstrasi()
    {
        return $this->belongsTo(Demonstrasi::class, 'id_demonstrasi');
    }

    // Relasi ke Skema
     public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }

    // Relasi ke Kelompok (opsional, kalau tabel kelompok ada)
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'id_kelompok');
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demonstrasi extends Model
{
    protected $table = 'demonstrasi';
    protected $primaryKey = 'id_demonstrasi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen',
        'id_kelompok',
        'id_skema',
        'id_asesor',
        'instruksi',
        'timer',
    ];

    // Relasi ke Skema
    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }

    // Relasi ke Asesor
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    // Relasi ke Kelompok
    public function kelompok()
    {
        return $this->belongsTo(KelompokPekerjaan::class, 'id_kelompok', 'id_kelompok');
    }

    // Relasi ke Asesmen
    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class, 'id_asesmen', 'id_asesmen');
    }

    // 🔹 Demonstrasi punya banyak tugas
    public function tugas()
    {
        return $this->hasMany(MasterTugasDemonstrasi::class, 'id_demonstrasi', 'id_demonstrasi');
    }
}

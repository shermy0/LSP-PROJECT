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
        'id_asesor',
        'timer',
    ];

    // Relasi ke Asesmen
    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class, 'id_asesmen', 'id_asesmen');
    }

    // Relasi ke Asesor
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    // 🔹 Demonstrasi punya banyak tugas
    public function tugas()
    {
        return $this->hasMany(MasterTugasDemonstrasi::class, 'id_demonstrasi', 'id_demonstrasi');
    }
    // Demonstrasi.php
public function skema()
{
    return $this->asesmen->skema(); // akses lewat asesmen
}

}

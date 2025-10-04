<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanDemonstrasi extends Model
{
    use HasFactory;

    protected $table = 'jawaban_demonstrasi';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = false;

    protected $fillable = [
        'id_tugas',
        'id_asesi',
        'id_skema',
        'jawaban_text',
        'jawaban_file',
    ];

    // Relasi ke Asesi
    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    // Relasi ke Skema
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    // Relasi ke Tugas Demonstrasi
    public function tugas()
    {
        return $this->belongsTo(MasterTugasDemonstrasi::class, 'id_tugas', 'id_tugas');
    }
}

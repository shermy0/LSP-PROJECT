<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPMO extends Model
{
    use HasFactory;

    protected $table = 'jawaban_pmo'; // sesuai nama tabel di migration

    protected $fillable = [
        'id_pembuatan_pertanyaan',
        'id_asesi',
        'jawaban',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendekatanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'pendekatan_asesmen';

    protected $fillable = [
        'skema_id',
        'user_id',
        'pilihan'
    ];

    protected $casts = [
        'pilihan' => 'array', // otomatis konversi JSON <-> array
    ];
}

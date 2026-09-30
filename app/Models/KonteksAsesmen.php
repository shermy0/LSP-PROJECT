<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonteksAsesmen extends Model
{
    use HasFactory;

    protected $table = 'konteks_asesmen';

    protected $fillable = [
        'skema_id', 'lingkungan', 'peluang', 'hubungan', 'pelaksana'
    ];

    protected $casts = [
        'hubungan' => 'array',
        'pelaksana' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesValidasi extends Model
{
    protected $table = 'proses_validasi';
    protected $fillable = [
        'tujuan',
        'tujuan_lain',
        'konteks',
        'konteks_lain',
        'pendekatan',
        'pendekatan_lain',
    ];
}
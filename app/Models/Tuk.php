<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuk extends Model
{
    use HasFactory;

    protected $table = 'tuk';
    protected $primaryKey = 'id_tuk';

    protected $fillable = [
        'nama_tuk','alamat','jenis_tuk'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tuk extends Model
{
    protected $table = 'tuk';       // nama tabel di DB
    protected $primaryKey = 'id_tuk'; // cek di DB, biasanya pk = id_tuk
    public $timestamps = false;     // kalo tabel tuk ga punya created_at / updated_at
}

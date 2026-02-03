<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuk extends Model
{
    use HasFactory;

    protected $table = 'kuk';
    protected $primaryKey = 'id_kuk';

    protected $fillable = [
        'id_elemen','deskripsi_kuk'
    ];

    public function elemen()
    {
        return $this->belongsTo(ElemenKompetensi::class, 'id_elemen');
    }
}
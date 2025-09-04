<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElemenKompetensi extends Model
{
    use HasFactory;

    protected $table = 'elemen_kompetensi';
    protected $primaryKey = 'id_elemen';

    protected $fillable = [
        'id_unit','nama_elemen'
    ];

    public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'id_unit');
    }

    public function kuk()
    {
        return $this->hasMany(Kuk::class, 'id_elemen');
    }
}
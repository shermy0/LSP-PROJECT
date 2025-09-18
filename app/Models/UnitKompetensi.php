<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKompetensi extends Model
{
    use HasFactory;

    protected $table = 'unit_kompetensi';
    protected $primaryKey = 'id_unit';

    protected $fillable = [
        'id_skema','kode_unit','judul_unit','deskripsi_unit'
    ];

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema');
    }

    public function elemenKompetensi()
    {
        return $this->hasMany(ElemenKompetensi::class, 'id_unit');
    }
}

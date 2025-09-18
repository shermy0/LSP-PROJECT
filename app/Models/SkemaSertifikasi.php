<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkemaSertifikasi extends Model
{
    use HasFactory;

    protected $table = 'skema_sertifikasi';
    protected $primaryKey = 'id_skema';

    protected $fillable = [
        'kode_skema','nama_skema','deskripsi'
    ];

    public function unitKompetensi()
    {
        return $this->hasMany(UnitKompetensi::class, 'id_skema');
    }
}

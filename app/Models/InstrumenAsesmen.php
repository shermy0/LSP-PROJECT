<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenAsesmen extends Model
{
    use HasFactory;

    protected $table = 'instrumen_asesmen';
    protected $primaryKey = 'id_instrumen';

    protected $fillable = [
        'nama_instrumen','kode_instrumen','jenis_instrumen','deskripsi'
    ];
}
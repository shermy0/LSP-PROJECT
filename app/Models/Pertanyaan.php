<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
protected $primaryKey = 'id_pertanyaan';
public $timestamps = false;

protected $fillable = [
    'id_unit',
    'id_skema',
    'id_asesor',
    'jenis_pertanyaan',
    'isi_pertanyaan',
    'deskripsi_pertanyaan',
    'kunci_jawaban',
    'file_path',
    'file_type',
];

}

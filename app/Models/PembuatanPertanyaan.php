<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembuatanPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pembuatan_pertanyaan';
    protected $primaryKey = 'id_pembuatan_pertanyaan';
    public $timestamps = false;

    protected $fillable = [
        'id_skema',
        'jenis_pertanyaan',
        'timer',
        'timescap'
    ];

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }
}

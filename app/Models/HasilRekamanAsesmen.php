<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilRekamanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'hasil_rekaman_asesmen';
    protected $primaryKey = 'id_bukti';
    public $timestamps = false;

    protected $fillable = [
        'id_rekaman',
        'id_unit',
        'observasi',
        'pernyataan_pihak_ketiga',
        'pertanyaan_wawancara',
        'pertanyaan_lisan',
        'pertanyaan_tertulis',
        'proyek_kerja',
        'lainnya'
    ];

    public function rekaman()
    {
        return $this->belongsTo(RekamanAsesmen::class, 'id_rekaman');
    }

    public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'id_unit');
    }
}

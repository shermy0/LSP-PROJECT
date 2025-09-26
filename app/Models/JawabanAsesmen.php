<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAsesmen extends Model
{
    use HasFactory;

    protected $table = 'jawaban_asesmen';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = false; // Karena migration kamu tidak ada timestamps

    protected $fillable = [
        'id_asesi',
        'id_asesmen',
        'id_unit',
        'id_skema',
        'id_pertanyaan',
        'jawaban_text',
        'jawaban_opsi',
        'pencapaian',
    ];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'id_pertanyaan', 'id_pertanyaan');
    }

    public function opsiJawaban()
    {
        return $this->belongsTo(OpsiJawaban::class, 'jawaban_opsi', 'id_opsi');
    }

    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class, 'id_asesmen', 'id_asesmen');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'id_unit', 'id_unit');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }
}
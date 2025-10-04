<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservasiCeklisItem extends Model
{
    use HasFactory;

    protected $table = 'observasi_ceklis_item';
    protected $primaryKey = 'id_observasi_item';
    public $timestamps = false;

    protected $fillable = [
        'id_observasi',
        'id_skema',
        'id_kelompok',
        'id_unit',
        'id_elemen',
        'id_kuk',
        'standar_industri',
        'pencapaian',
        'penilaian_lanjut',
    ];

    public function observasi()
    {
        return $this->belongsTo(ObservasiCeklis::class, 'id_observasi', 'id_observasi');
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'id_unit', 'id_unit');
    }

    public function kelompokpekerjaan()
    {
        return $this->belongsTo(KelompokPekerjaan::class, 'id_kelompok', 'id_kelompok');
    }

    public function elemen()
    {
        return $this->belongsTo(ElemenKompetensi::class, 'id_elemen', 'id_elemen');
    }

    public function kuk()
    {
        return $this->belongsTo(Kuk::class, 'id_kuk', 'id_kuk');
    }
}

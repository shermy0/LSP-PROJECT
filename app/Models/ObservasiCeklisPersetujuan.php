<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservasiCeklisPersetujuan extends Model
{
    use HasFactory;

    protected $table = 'observasi_ceklis_persetujuan';
    protected $primaryKey = 'id_observasi_persetujuan';
    public $timestamps = false;

    protected $fillable = [
        'id_observasi',
        'tgl_ttd_asesi',
        'ttd_asesi',
        'tgl_ttd_asesor',
        'ttd_asesor',
    ];

    public function observasi()
    {
        return $this->belongsTo(ObservasiCeklis::class, 'id_observasi', 'id_observasi');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfirmasiOrangRelevanPersetujuan extends Model
{
    protected $table = 'konfirmasi_orang_relevan_persetujuan';
    protected $primaryKey = 'id_konfirmasi_persetujuan';
    public $timestamps = false;

    protected $fillable = [
        'id_konfirmasi',
        'ttd_pemberi_konfirmasi',
        'tgl_ttd_pemberi_konfirmasi',
    ];

    public function konfirmasi()
    {
        return $this->belongsTo(KonfirmasiOrangRelevan::class, 'id_konfirmasi');
    }
}

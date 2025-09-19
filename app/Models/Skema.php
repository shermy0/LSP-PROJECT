<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    protected $table = 'skema_sertifikasi'; 
    protected $primaryKey = 'id_skema';
    public $timestamps = false;

    protected $fillable = [
        'nama_skema',
        'kode_skema',
        'jenjang',
        'bidang_keahlian',
        'deskripsi',
        'status_skema'
    ];

    public function units()
    {
        return $this->hasMany(UnitKompetensi::class, 'id_skema', 'id_skema');
    }

    public function instrumen()
    {
        return $this->hasMany(InstrumenAsesmen::class, 'skema_id', 'id_skema');
    }
    public function kelompokPekerjaan()
{
    return $this->hasMany(KelompokPekerjaan::class, 'id_skema', 'id_skema');
}
}

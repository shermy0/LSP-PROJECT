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
        'status_skema',
        'standar_kompetensi'
    ];

        public function unitKompetensi()
    {
        return $this->hasMany(UnitKompetensi::class, 'id_skema', 'id_skema');
    }

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
    public function tujuans()
    {
        return $this->belongsToMany(
            TujuanAsesmen::class,
            'skema_tujuan',   // nama pivot
            'skema_id',       // foreign key di pivot untuk skema
            'tujuan_id'       // foreign key di pivot untuk tujuan
        );
    }

      public function laporan()
    {
        return $this->hasMany(LaporanAsesmen::class, 'skema_id');
    }

    public function validasi()
    {
        return $this->hasMany(ValidasiAsesmen::class, 'skema_id');
    }

    public function konfirmasi()
    {
        return $this->hasMany(KonfirmasiOrangRelevan::class, 'skema_id');
    }

    public function asesor()
    {
        return $this->belongsToMany(Asesor::class, 'skema_asesor', 'id_skema', 'id_asesor');
    }

    public function dasarAsesmen()
{
    return $this->hasOne(DasarAsesmen::class, 'skema_id', 'id_skema');
}

}

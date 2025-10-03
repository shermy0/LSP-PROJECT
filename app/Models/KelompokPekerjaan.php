<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokPekerjaan extends Model
{
    protected $table = 'kelompok_pekerjaan';
    protected $primaryKey = 'id_kelompok';
    protected $fillable = ['id_skema', 'nama_kelompok'];
    public $timestamps = false;

    public function hasilAsesmen()
    {
        return $this->hasMany(HasilAsesmen::class, 'id_kelompok', 'id_kelompok');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }
     public function unitKompetensi()
    {
        return $this->belongsToMany(UnitKompetensi::class, 'hasil_asesmen', 'id_kelompok', 'id_unit')
                    ->withPivot('id_hasil', 'status', 'catatan'); 
    }
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'id_kelompok', 'id_kelompok');
    }

public function units()
{
    return $this->hasManyThrough(
        UnitKompetensi::class, 
        HasilAsesmen::class,
        'id_kelompok', // Foreign key di hasil_asesmen
        'id_unit',     // Foreign key di unit_kompetensi
        'id_kelompok', // Local key di kelompok_pekerjaan
        'id_unit'      // Local key di hasil_asesmen
    );
}

}

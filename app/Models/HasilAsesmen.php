<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilAsesmen extends Model
{
    use HasFactory;

    protected $table = 'hasil_asesmen';
    protected $primaryKey = 'id_hasil';
    public $timestamps = false; // ⬅ ini biar nggak cari created_at & updated_at
protected $fillable = [
    'id_asesor',
    'id_asesi',
    'id_unit',
    'catatan',
    'status',
];


    
    public function bukti()
    {
        return $this->hasMany(HasilAsesmenBukti::class, 'id_hasil');
    }

    public function perangkat()
    {
        return $this->hasMany(HasilAsesmenPerangkat::class, 'id_hasil');
    }

    // Relasi ke UnitKompetensi
    public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'id_unit', 'id_unit');
    }

    // Relasi ke InstrumenAsesmen
    public function instrumen()
    {
        return $this->belongsTo(InstrumenAsesmen::class, 'id_instrumen', 'id_instrumen');
    }

    // Relasi ke Jenis Bukti
    public function jenisBukti()
    {
        return $this->belongsTo(MasterJenisBukti::class, 'id_jenis_bukti', 'id_jenis_bukti');
    }

    public function unitKompetensi()
{
    return $this->belongsTo(UnitKompetensi::class, 'id_unit', 'id_unit');
}

}
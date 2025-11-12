<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilAsesmenBukti extends Model
{
    protected $table = 'hasil_asesmen_bukti';
    protected $fillable = ['id_hasil', 'id_jenis_bukti'];

        public function unit()
    {
        return $this->belongsTo(UnitKompetensi::class, 'id_unit', 'id_unit');
    }

    public function hasil()
    {
        return $this->belongsTo(HasilAsesmen::class, 'id_hasil');
    }

public function jenisBukti()
{
    return $this->belongsTo(MasterJenisBukti::class, 'id_jenis_bukti', 'id_jenis_bukti');
}


    public function kelompok()
    {
        return $this->belongsTo(KelompokPekerjaan::class, 'id_kelompok', 'id_kelompok');
    }

}

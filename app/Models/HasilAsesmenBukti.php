<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilAsesmenBukti extends Model
{
    protected $table = 'hasil_asesmen_bukti';
    protected $fillable = ['id_hasil', 'id_jenis_bukti'];

    public function hasil()
    {
        return $this->belongsTo(HasilAsesmen::class, 'id_hasil');
    }

    public function jenisBukti()
    {
        return $this->belongsTo(MasterJenisBukti::class, 'id_jenis_bukti');
    }
}

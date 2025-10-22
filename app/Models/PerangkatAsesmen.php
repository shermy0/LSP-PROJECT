<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatAsesmen extends Model
{
    protected $table = 'perangkat_asesmen';
    protected $primaryKey = 'id_perangkat';
    public $timestamps = true;

    protected $fillable = [
        'id_unit',
        'id_instrumen',
        'jenis_bukti',
        'catatan_penerapan'
    ];

public function jenisBukti()
{
    return $this->belongsTo(MasterJenisBukti::class, 'id_jenis_bukti', 'id_jenis_bukti');
}

}

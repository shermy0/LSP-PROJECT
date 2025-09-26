<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJenisBukti extends Model
{
    protected $table = 'master_jenis_bukti';
    protected $primaryKey = 'id_jenis_bukti';
    public $timestamps = false;

    protected $fillable = ['nama_bukti'];

    public function perangkat()
    {
        return $this->hasMany(PerangkatAsesmen::class, 'id_jenis_bukti');
    }
}
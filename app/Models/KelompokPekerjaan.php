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
}

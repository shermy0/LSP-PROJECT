<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJenisBukti extends Model
{
    protected $table = 'master_jenis_bukti';
    protected $primaryKey = 'id_jenis_bukti';
    public $timestamps = false;

    protected $fillable = ['nama_bukti'];
    public function persetujuan()
{
    return $this->belongsToMany(
        PersetujuanAsesmen::class,
        'persetujuan_bukti',
        'id_jenis_bukti',
        'id_persetujuan'
    )->using(PersetujuanAsesmenBukti::class)
     ->withPivot('dipilih');
}


}
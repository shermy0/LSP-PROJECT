<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesmenMandiriMaster extends Model
{
    protected $table = 'asesmen_mandiri_master';
    protected $primaryKey = 'id_asesmen_mandiri';
    public $timestamps = false;

    protected $fillable = [
        'id_permohonan',
        'id_asesi',
        'id_asesor',
        'rekomendasi'
    ];

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi');
    }

    public function jawaban()
    {
        return $this->hasMany(AsesmenMandiriJawaban::class, 'id_asesmen_mandiri');
    }
}

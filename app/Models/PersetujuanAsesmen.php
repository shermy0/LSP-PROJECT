<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanAsesmen extends Model
{
    protected $table = 'persetujuan_asesmen';
    protected $primaryKey = 'id_persetujuan'; // sesuaikan dengan nama PK
    protected $fillable = [
        'asesi_id', 'asesor_id', 'skema_id', 'tuk_id'
    ];

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'asesi_id', 'id');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'asesor_id', 'id');
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id', 'id');
    }

    public function tuk()
    {
        return $this->belongsTo(Tuk::class, 'tuk_id', 'id');
    }
}

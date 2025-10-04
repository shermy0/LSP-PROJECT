<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesorSkema extends Model
{
    use HasFactory;

    protected $table = 'asesor_skema';

    protected $fillable = [
        'asesor_id',
        'skema_id',
    ];

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'asesor_id', 'id_asesor');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'skema_id', 'id_skema');
    }
}

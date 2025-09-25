<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapa01OrangRelevan extends Model
{
    protected $table = 'mapa01_orang_relevan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'skema_id',
        'jabatan',
    ];

    // Relasi ke Skema
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id', 'id_skema');
    }
}

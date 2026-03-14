<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarPotensi extends Model
{
    protected $table = 'penyesuaian_wajar_potensi';
    protected $primaryKey = 'id_potensi';
    public $timestamps = false;
    protected $fillable = [
        'id_penyesuaian',
        'potensi',
        'dipilih',
    ];

    public function penyesuaian()
    {
        return $this->belongsTo(PenyesuaianWajar::class, 'id_penyesuaian');
    }
}
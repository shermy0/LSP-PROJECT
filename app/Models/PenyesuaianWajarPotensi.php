<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarPotensi extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_wajar_potensi';
    protected $primaryKey = 'id_potensi';
    public $timestamps = true;

    protected $fillable = [
        'id_penyesuaian',
        'teks_potensi',
        'dipilih',
    ];

    protected $casts = [
        'dipilih' => 'boolean',
    ];

    // Relasi balik ke penyesuaian wajar
    public function penyesuaianWajar()
    {
        return $this->belongsTo(PenyesuaianWajar::class, 'id_penyesuaian', 'id_penyesuaian');
    }
}
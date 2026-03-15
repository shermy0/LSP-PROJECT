<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarPersetujuan extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_wajar_persetujuan';
    protected $primaryKey = 'id_penyesuaian_persetujuan';
    public $timestamps = true;

    protected $fillable = [
        'id_penyesuaian',
        'tgl_ttd_asesor',
        'ttd_asesor',
        'tgl_ttd_asesi',
        'ttd_asesi',
    ];

    protected $casts = [
        'tgl_ttd_asesor' => 'date',
        'tgl_ttd_asesi'  => 'date',
    ];

    // Relasi balik ke penyesuaian wajar
    public function penyesuaianWajar()
    {
        return $this->belongsTo(PenyesuaianWajar::class, 'id_penyesuaian', 'id_penyesuaian');
    }
}
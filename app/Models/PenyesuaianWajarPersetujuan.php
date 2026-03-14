<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarPersetujuan extends Model
{
    protected $table = 'penyesuaian_wajar_persetujuan';
    protected $primaryKey = 'id_penyesuaian_persetujuan';
    public $timestamps = false;
    protected $fillable = [
        'id_penyesuaian',
        'tgl_ttd_asesor',
        'ttd_asesor',
        'tgl_ttd_asesi',
        'ttd_asesi',
    ];

    public function penyesuaian()
    {
        return $this->belongsTo(PenyesuaianWajar::class, 'id_penyesuaian');
    }
}
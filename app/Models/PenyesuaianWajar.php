<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajar extends Model
{
    protected $table = 'penyesuaian_wajar';
    protected $primaryKey = 'id_penyesuaian';
    protected $fillable = [
        'id_asesmen',
        'id_asesi',
        'id_asesor',
        'hasil_penyesuaian',
        'acuan_pembanding',
        'metode_asesmen',
        'instrumen_asesmen',
        'status',
    ];

    public function asesmen()
    {
        return $this->belongsTo(Asesmen::class, 'id_asesmen');
    }

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor');
    }

    public function potensi()
    {
        return $this->hasMany(PenyesuaianWajarPotensi::class, 'id_penyesuaian');
    }

    public function items()
    {
        return $this->hasMany(PenyesuaianWajarItem::class, 'id_penyesuaian');
    }

    public function persetujuan()
    {
        return $this->hasOne(PenyesuaianWajarPersetujuan::class, 'id_penyesuaian');
    }
}
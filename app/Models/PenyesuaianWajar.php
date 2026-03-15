<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajar extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_wajar';
    protected $primaryKey = 'id_penyesuaian';
    public $timestamps = true;

    protected $fillable = [
        'id_permohonan',
        'id_asesi',
        'id_asesor',
        'acuan_pembanding',
        'metode_asesmen',
        'instrumen_asesmen',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke permohonan
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id_permohonan');
    }

    // Relasi ke asesi
    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    // Relasi ke asesor
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    // Relasi ke potensi
    public function potensi()
    {
        return $this->hasMany(PenyesuaianWajarPotensi::class, 'id_penyesuaian', 'id_penyesuaian');
    }

    // Relasi ke items
    public function items()
    {
        return $this->hasMany(PenyesuaianWajarItem::class, 'id_penyesuaian', 'id_penyesuaian');
    }

    // Relasi ke persetujuan
    public function persetujuan()
    {
        return $this->hasOne(PenyesuaianWajarPersetujuan::class, 'id_penyesuaian', 'id_penyesuaian');
    }
}
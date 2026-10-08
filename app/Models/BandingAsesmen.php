<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandingAsesmen extends Model
{
    use HasFactory;

    protected $table = 'banding_asesmen';
    protected $primaryKey = 'id_banding';
    public $timestamps = true;

    protected $fillable = [
        'id_asesi',
        'id_permohonan',
        'id_skema',
        'tgl_asesmen',
        'banding_dijelaskan',
        'diskusi_dengan_asesor',
        'libatkan_orang_lain',
        'alasan_banding',
        'tgl_banding',
    ];

    protected $casts = [
        'tgl_asesmen' => 'date',
        'tgl_banding' => 'date',
    ];

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id_permohonan');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }

    public function persetujuan()
    {
        return $this->hasOne(BandingAsesmenPersetujuan::class, 'id_banding', 'id_banding');
    }
}
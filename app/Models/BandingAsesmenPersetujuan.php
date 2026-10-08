<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandingAsesmenPersetujuan extends Model
{
    use HasFactory;

    protected $table = 'banding_asesmen_persetujuan';
    protected $primaryKey = 'id_banding_persetujuan';
    public $timestamps = true;

    protected $fillable = [
        'id_banding',
        'tgl_ttd_asesi',
        'ttd_asesi',
    ];

    protected $casts = [
        'tgl_ttd_asesi' => 'date',
    ];

    public function banding()
    {
        return $this->belongsTo(BandingAsesmen::class, 'id_banding', 'id_banding');
    }
}
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandingAsesmenPersetujuan extends Model
{
    protected $table = 'banding_asesmen_persetujuan';
    protected $primaryKey = 'id_banding_persetujuan';
    public $timestamps = false;
    protected $fillable = [
        'id_banding', 'tgl_ttd_asesi', 'ttd_asesi'
    ];
}

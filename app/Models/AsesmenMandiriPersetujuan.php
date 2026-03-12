<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesmenMandiriPersetujuan extends Model
{
    protected $table = 'asesmen_mandiri_persetujuan';
    protected $primaryKey = 'id_asesmen_mandiri_persetujuan';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen_mandiri',
        'tgl_ttd_asesi',
        'ttd_asesi',
        'tgl_ttd_asesor',
        'ttd_asesor',
        'status_persetujuan',
        'catatan'
    ];
}

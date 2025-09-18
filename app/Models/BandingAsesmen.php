<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandingAsesmen extends Model
{
    protected $table = 'banding_asesmen';
    protected $primaryKey = 'id_banding';
    public $timestamps = false;
    protected $fillable = [
        'id_asesi', 'tgl_asesmen', 'banding_dijelaskan', 'diskusi_dengan_asesor', 'alasan_banding', 'tgl_banding'
    ];

    public function Asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi');
    }
}

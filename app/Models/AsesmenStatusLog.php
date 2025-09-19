<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesmenStatusLog extends Model
{
    protected $table = 'asesmen_status_log';
    protected $primaryKey = 'id_asesmen_status_log';
    public $timestamps = false;
    protected $fillable = [
        'id_asesmen', 'id_status_asesmen', 'keterangan', 'changed_at', 'changed_by'
    ];

    public function asesmen()
    {
        return $this->belongsTo(asesmen::class, 'id_asesmen');
    }
}

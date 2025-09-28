<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanAsesmen extends Model
{
    protected $table = 'tujuan_asesmen';
    protected $primaryKey = 'id_tujuan';
    protected $fillable = ['nama_tujuan'];
    public $timestamps = false; 

    public function skemas()
    {
        return $this->belongsToMany(Skema::class, 'skema_tujuan', 'tujuan_id', 'skema_id');
    }
}


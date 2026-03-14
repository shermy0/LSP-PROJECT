<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarItem extends Model
{
    protected $table = 'penyesuaian_wajar_item';
    protected $primaryKey = 'id_item';
    public $timestamps = false;
    protected $fillable = [
        'id_penyesuaian',
        'jenis_modifikasi',
        'dipilih',
        'keterangan',
    ];

    public function penyesuaian()
    {
        return $this->belongsTo(PenyesuaianWajar::class, 'id_penyesuaian');
    }

    public function details()
    {
        return $this->hasMany(PenyesuaianWajarItemDetail::class, 'id_item');
    }
}
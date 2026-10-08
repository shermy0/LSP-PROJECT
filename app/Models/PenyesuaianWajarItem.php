<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarItem extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_wajar_item';
    protected $primaryKey = 'id_item';
    public $timestamps = true;

    protected $fillable = [
        'id_penyesuaian',
        'nomor_item',
        'dipilih',
    ];

    protected $casts = [
        'nomor_item' => 'integer',
        'dipilih'    => 'boolean',
    ];

    // Relasi balik ke penyesuaian wajar
    public function penyesuaianWajar()
    {
        return $this->belongsTo(PenyesuaianWajar::class, 'id_penyesuaian', 'id_penyesuaian');
    }

    // Relasi ke keterangan item (checkbox & lainnya)
    public function keteranganItems()
    {
        return $this->hasMany(PenyesuaianWajarKeteranganItem::class, 'id_item', 'id_item');
    }
}
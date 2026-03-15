<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarKeteranganItem extends Model
{
    use HasFactory;

    protected $table = 'penyesuaian_wajar_keterangan_item';
    protected $primaryKey = 'id_keterangan';
    public $timestamps = true;

    protected $fillable = [
        'id_item',
        'keterangan',
        'is_lainnya',
    ];

    protected $casts = [
        'is_lainnya' => 'boolean',
    ];

    // Relasi balik ke item
    public function item()
    {
        return $this->belongsTo(PenyesuaianWajarItem::class, 'id_item', 'id_item');
    }
}
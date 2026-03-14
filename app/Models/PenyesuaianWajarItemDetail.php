<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianWajarItemDetail extends Model
{
    protected $table = 'penyesuaian_wajar_item_detail';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;
    protected $fillable = [
        'id_item',
        'alasan',
        'catatan',
    ];

    public function item()
    {
        return $this->belongsTo(PenyesuaianWajarItem::class, 'id_item');
    }
}
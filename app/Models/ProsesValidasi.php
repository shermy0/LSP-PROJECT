<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsesValidasi extends Model
{
    use HasFactory;

    protected $table = 'proses_validasi';
    protected $primaryKey = 'id_validasi';
    public $timestamps = false; // sesuaikan jika tabel tidak pakai created_at/updated_at

    protected $fillable = [
        'skema_id', 'periode', 'tujuan', 'tujuan_lain',
        'konteks', 'konteks_lain', 'pendekatan', 'pendekatan_lain'
    ];
}

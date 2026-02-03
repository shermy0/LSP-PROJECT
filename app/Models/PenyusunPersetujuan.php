<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyusunPersetujuan extends Model
{
    protected $table = 'penyusun_persetujuan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_asesor',
        'id_skema',
        'no_met',
        'tanggal',
        'tanda_tangan',
        'catatan',

    ];
}

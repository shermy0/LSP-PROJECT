<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyusunPersetujuan extends Model
{
    use HasFactory;

    protected $table = 'penyusun_persetujuan';

    protected $fillable = [
        'asesor_id',
        'tanggal_asesmen',
        'tanda_tangan',
        'komentar',
    ];
}

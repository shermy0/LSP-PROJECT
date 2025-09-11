<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemonstrasiPersetujuan extends Model
{
    protected $table = 'demonstrasi_persetujuan';
    protected $primaryKey = 'id_demonstrasi_persetujuan';
    public $timestamps = false;
    protected $fillable = [
        'id_demonstrasi', 'tgl_ttd_asesor', 'ttd_asesor'
    ];
}

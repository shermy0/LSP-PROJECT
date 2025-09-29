<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesmenMandiriJawaban extends Model
{
    protected $table = 'asesmen_mandiri_jawaban';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = false;
    protected $fillable = [
        'id_asesmen_mandiri', 'id_kuk', 'status', 'id_dokumen'
    ];
}

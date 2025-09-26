<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demonstrasi extends Model
{
    protected $table = 'demonstrasi';
    protected $primaryKey = 'id_demonstrasi';
    public $timestamps = false;
    protected $fillable = [
        'id_asesmen', 'id_tuk', 'id_kuk', 'id_asesor'
    ];

    public function Asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor');
    }

    public function kuk()
    {
        return $this->belongsTo(Kuk::class, 'id_kuk');
    }
}

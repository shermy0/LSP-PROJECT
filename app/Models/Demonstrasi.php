<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demonstrasi extends Model
{
    protected $table = 'demonstrasi';
    protected $primaryKey = 'id_demonstrasi';
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen','id_skema','timer','timescap'
    ];

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    public function tugas()
    {
        return $this->hasMany(MasterTugasDemonstrasi::class, 'id_demonstrasi', 'id_demonstrasi');
    }
}

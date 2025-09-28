<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    protected $table = 'asesor';
    protected $primaryKey = 'id_asesor';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nama_asesor',
        'nip',
        'email',
        'bidang_keahlian',
        'jabatan',
        'no_registrasi',
    ];

    // Jika asesor terhubung ke skema
    public function skema()
    {
        return $this->belongsToMany(Skema::class, 'skema_asesor', 'id_asesor', 'id_skema');
    }
}

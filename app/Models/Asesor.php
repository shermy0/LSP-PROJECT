<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';
    protected $primaryKey = 'id_asesor';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'nama_asesor',
        'nip',
        'keahlian',
        'tanda_tangan',
        'jabatan',
        'no_registrasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

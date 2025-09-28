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
        'user_id','nama_asesor','nip','email','bidang_keahlian','jabatan','no_registrasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asesis()
    {
        return $this->hasMany(Asesi::class);
    }

}
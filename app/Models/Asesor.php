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
        'user_id','nama_asesor','nip','email','keahlian','jabatan','no_registrasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asesi()
    {
        return $this->hasMany(Asesi::class, 'asesor_id', 'id_asesor');
    }
        public function skema()
    {
        return $this->belongsToMany(Skema::class, 'skema_asesor', 'id_asesor', 'id_skema');
    }
    public function skemas()
    {
        return $this->belongsToMany(Skema::class, 'asesor_skema', 'asesor_id', 'skema_id');
    }
}
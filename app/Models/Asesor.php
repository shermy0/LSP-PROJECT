<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';
    protected $primaryKey = 'id_asesor';
    public $timestamps = true; // migration menggunakan timestamps
    protected $fillable = [
        'user_id',
        'nama_asesor',
        'nip',
        'email',
        'jabatan',
        'id_jurusan', // menggantikan keahlian
        'no_registrasi'
    ];

    /**
     * Relasi ke User (setiap asesor adalah user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Jurusan (bidang keahlian asesor)
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    /**
     * Relasi many-to-many dengan SkemaSertifikasi.
     */
    public function skemas()
    {
        return $this->belongsToMany(
            SkemaSertifikasi::class,
            'asesor_skema',     // tabel pivot
            'id_asesor',         // foreign key di pivot ke asesor
            'id_skema'           // foreign key di pivot ke skema
        )->withTimestamps();     // jika tabel pivot punya timestamps
    }
}
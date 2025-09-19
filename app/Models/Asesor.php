<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor'; // nama tabel di database
    protected $primaryKey = 'id_asesor'; // primary key
    public $timestamps = true; // kalau pakai created_at & updated_at

    protected $fillable = [
        'user_id',
        'nama_asesor',
        'nip',
        'email',
        'bidang_keahlian',
        'jabatan',
        'no_registrasi',
    ];
}

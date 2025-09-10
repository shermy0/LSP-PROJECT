<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema_sertifikasi';           // Nama tabel
    protected $primaryKey = 'id_skema';   // Primary key
    public $timestamps = false;           // Tidak ada created_at & updated_at

    protected $fillable = [
        'nama_skema',
        'kode_skema',
        'jenjang',
        'bidang_keahlian',
        'deskripsi',
        'status_skema',
    ];
}

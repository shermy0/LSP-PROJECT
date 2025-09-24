<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokPekerjaan extends Model
{
    use HasFactory;

    // nama tabel
    protected $table = 'kelompok_pekerjaan';

    // primary key
    protected $primaryKey = 'id_kelompok';

    // kalau tidak pakai created_at / updated_at
    public $timestamps = false;

    // kolom yang bisa diisi
    protected $fillable = [
        'id_skema',
        'nama_kelompok',
    ];

    /**
     * Relasi ke Skema Sertifikasi
     * (many-to-one → satu kelompok milik satu skema)
     */
    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }
}

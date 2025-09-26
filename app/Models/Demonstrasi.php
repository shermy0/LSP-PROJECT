<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Demonstrasi extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau sama dengan plural nama model)
    protected $table = 'demonstrasi';

    // Primary key
    protected $primaryKey = 'id_demonstrasi';

    // Kalau tidak pakai created_at & updated_at
    public $timestamps = false;

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'id_skema',
        'timer',
        'timescap',
    ];

    /**
     * Relasi ke Skema Sertifikasi
     */
    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }
}

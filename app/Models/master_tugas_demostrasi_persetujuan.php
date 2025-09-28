<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterTugasDemonstrasiPersetujuan extends Model
{
    use HasFactory;

    protected $table = 'master_tugas_demostrasi_persetujuan';
    protected $primaryKey = 'id_tugas_demonstrasi_persetujuan';
    public $timestamps = false;

    protected $fillable = [
        'id_demonstrasi',
        'id_asesor',
        'tgl_ttd_asesor',
        'ttd_asesor',
    ];

    /**
     * Relasi ke Demonstrasi
     */
    public function demonstrasi()
    {
        return $this->belongsTo(Demonstrasi::class, 'id_demonstrasi', 'id_demonstrasi');
    }

    /**
     * Relasi ke Asesor
     */
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
}

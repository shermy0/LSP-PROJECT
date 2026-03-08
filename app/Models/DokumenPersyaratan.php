<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_persyaratan';

    protected $primaryKey = 'id_dokumen';

    public $timestamps = true;

    protected $fillable = [
        'id_permohonan',
        'id_jenis_dokumen',
        'nama_file',
        'path_file',
        'ada',
        'memenuhi_syarat',
        'catatan',
    ];

    // ===============================
    // 🔗 RELASI
    // ===============================

    /**
     * Relasi ke tabel permohonan
     */
    public function permohonan()
    {
        return $this->belongsTo(
            Permohonan::class,
            'id_permohonan',
            'id_permohonan'
        );
    }

    /**
     * Relasi ke master jenis dokumen
     */
    public function jenisDokumen()
    {
        return $this->belongsTo(
            JenisDokumen::class,
            'id_jenis_dokumen',
            'id_jenis_dokumen'
        );
    }

    // ===============================
    // ACCESSOR
    // ===============================

    /**
     * Mengambil URL file dokumen
     */
    public function getFileUrlAttribute()
    {
        if ($this->path_file) {
            return asset('storage/' . $this->path_file);
        }

        return null;
    }

    /**
     * Mengambil nama dokumen dari relasi
     */
    public function getNamaDokumenAttribute()
    {
        return $this->jenisDokumen
            ? $this->jenisDokumen->nama_dokumen
            : 'Dokumen #' . $this->id_jenis_dokumen;
    }
}
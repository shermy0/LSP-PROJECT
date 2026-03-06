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
        'permohonan_id',
        'jenis_dokumen_id',
        'nama_file',
        'path_file',
        'ada',
        'memenuhi_syarat',
        'catatan',
    ];

    // ===============================
    // 🔗 RELASI ELOQUENT
    // ===============================

    /**
     * Dokumen ini milik permohonan tertentu
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id', 'id_permohonan');
    }

    /**
     * Jenis dokumen (master dokumen)
     */
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_dokumen_id', 'id_jenis_dokumen');
    }

    // ===============================
    // 🧩 ACCESSOR (Opsional)
    // ===============================

    /**
     * URL file dokumen (jika disimpan di storage Laravel)
     */
    public function getFileUrlAttribute()
    {
        return $this->path_file
            ? asset('storage/' . $this->path_file)
            : null;
    }
}

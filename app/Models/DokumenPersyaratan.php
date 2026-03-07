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
    // 🔗 RELASI ELOQUENT
    // ===============================

    /**
     * Dokumen ini milik permohonan tertentu
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id_permohonan');
    }

    /**
     * Jenis dokumen (master dokumen)
     */
    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen', 'id_jenis_dokumen');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumen';
    protected $primaryKey = 'id_jenis_dokumen';
    public $timestamps = true;

    protected $fillable = [
        'nama_dokumen',
        'keterangan',
        'wajib',
    ];

    // ===============================
    // 🔗 RELASI ELOQUENT
    // ===============================

    /**
     * Setiap jenis dokumen bisa dimiliki oleh banyak dokumen persyaratan.
     */
    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class, 'jenis_dokumen_id', 'id_jenis_dokumen');
    }
}

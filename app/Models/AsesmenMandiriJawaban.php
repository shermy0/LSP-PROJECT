<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesmenMandiriJawaban extends Model
{
    protected $table = 'asesmen_mandiri_jawaban';
    protected $primaryKey = 'id_jawaban'; // di SQL yang kamu kirim primary key ini
    public $timestamps = false;

    protected $fillable = [
        'id_asesmen_mandiri',
        'id_kuk',
        'status',
        'id_dokumen',
    ];

    // 🔹 Relasi ke Master
    public function master()
    {
        return $this->belongsTo(AsesmenMandiriMaster::class, 'id_asesmen_mandiri', 'id_asesmen_mandiri');
    }

    // 🔹 Relasi ke Dokumen (pastikan nama model sesuai)
    public function dokumen()
    {
        return $this->belongsTo(DokumenPersyaratan::class, 'id_dokumen', 'id_dokumen');
    }

    // 🔹 Relasi ke KUK
    public function kuk()
    {
        return $this->belongsTo(Kuk::class, 'id_kuk', 'id_kuk');
    }
}

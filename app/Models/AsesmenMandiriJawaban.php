<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsesmenMandiriJawaban extends Model
{
    protected $table = 'asesmen_mandiri_jawaban';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = true;

    protected $fillable = [
        'id_asesmen_mandiri',
        'id_kuk',
        'status',
        'id_dokumen',
        'file_lain',
    ];

    public function master()
    {
        return $this->belongsTo(AsesmenMandiriMaster::class, 'id_asesmen_mandiri');
    }

    public function dokumen()
    {
        return $this->belongsTo(DokumenPersyaratan::class, 'id_dokumen', 'id_dokumen');
    }

    public function kuk()
    {
        return $this->belongsTo(Kuk::class, 'id_kuk', 'id_kuk');
    }
}

<?php
// app/Models/PersetujuanAsesmen.php
namespace App\Models;
use App\Models\PersetujuanAsesmenBukti;
use Illuminate\Database\Eloquent\Model;

class PersetujuanAsesmen extends Model
{
    protected $table = 'persetujuan_asesmen';
    protected $primaryKey = 'id_persetujuan';
    public $timestamps = false; // <--- tambahin ini biar ga nyari created_at & updated_at

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'id_skema',
        'id_tuk',
        'hari',
        'tgl_pelaksanaan',
        'waktu',
        'lokasi',
        'pernyataan_kerahasiaan',
        'setuju_asesmen',
    ];

    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }

    public function tuk()
    {
        return $this->belongsTo(Tuk::class, 'id_tuk', 'id_tuk');
    }
    // App\Models\PersetujuanAsesmen.php
public function bukti()
{
    return $this->belongsToMany(
        MasterJenisBukti::class,
        'persetujuan_bukti',
        'id_persetujuan',
        'id_jenis_bukti'
    )->withPivot('dipilih'  );
}

// khusus untuk bukti yang dipilih asesor
// App\Models\PersetujuanAsesmen.php
public function buktiDipilih()
{
    return $this->belongsToMany(
        MasterJenisBukti::class,
        'persetujuan_bukti',
        'id_persetujuan',
        'id_jenis_bukti'
    )->using(PersetujuanAsesmenBukti::class)
     ->withPivot('dipilih');
}

public function buktiUpload()
{
    return $this->hasMany(PersetujuanAsesmenBukti::class, 'id_persetujuan');
}

}

/*
 * Remove PersetujuanAsesmenBukti class from this file.
 * Define it in app/Models/PersetujuanAsesmenBukti.php instead.
 */

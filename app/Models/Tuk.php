<?php
// app/Models/Tuk.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tuk extends Model
{
    protected $table = 'tuk';
    protected $primaryKey = 'id_tuk';
    public $timestamps = false;

    protected $fillable = [
        'nama_tuk',
        'jenis_tuk',
        'alamat_tuk',
        'status_tuk'
    ];

    public function persetujuan()
    {
        return $this->hasMany(PersetujuanAsesmen::class, 'id_tuk');
    }
}
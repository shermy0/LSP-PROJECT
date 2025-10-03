<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesi extends Model
{
    use HasFactory;

    protected $table = 'asesi';
    protected $primaryKey = 'id_asesi';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'asesor_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'kebangsaan',
        'alamat',
        'telepon',
        'email',
        'pendidikan_terakhir',
        'institusi',
        'jabatan',
        'alamat_kantor',
        'telepon_kantor',
    ];

    public function skema()
    {
        return $this->belongsTo(Skema::class, 'skema_id');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'asesor_id', 'id_asesor');
    }
}
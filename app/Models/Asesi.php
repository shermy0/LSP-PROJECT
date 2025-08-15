<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesi extends Model
{
    use HasFactory;

    protected $table = 'asesi';
    protected $primaryKey = 'id_asesi';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'kebangsaan',
        'alamat',
        'telepon',
        'pendidikan_terakhir',
        'institusi',
        'jabatan',
        'alamat_kantor',
        'telepon_kantor',
        'tanda_tangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

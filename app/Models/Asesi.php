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

        // 🏠 Data pribadi
        'alamat_rumah',
        'kode_pos_rumah',
        'telepon_rumah',
        'telepon_hp',
        'email',

        // 🎓 Pendidikan
        'kualifikasi_pendidikan',

        // 💼 Pekerjaan / Institusi
        'nama_institusi',
        'jabatan',
        'alamat_kantor',
        'kode_pos_kantor',
        'telepon_kantor',
        'fax_kantor',
        'email_kantor',
    ];

    // ===============================
    // 🔗 RELASI ELOQUENT
    // ===============================

    /**
     * Setiap Asesi dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Setiap Asesi bisa dibimbing oleh satu Asesor.
     */
    public function asesor()
    {
        return $this->belongsTo(Asesor::class, 'asesor_id', 'id_asesor');
    }

    /**
     * Setiap Asesi dapat memiliki banyak Permohonan Sertifikasi.
     */
    public function permohonan()
    {
        return $this->hasMany(Permohonan::class, 'asesi_id', 'id_asesi');
    }

    /**
     * Shortcut: ambil permohonan terakhir (terbaru).
     */
    public function permohonanTerakhir()
    {
        return $this->hasOne(Permohonan::class, 'asesi_id', 'id_asesi')->latestOfMany();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';
    protected $primaryKey = 'id_permohonan';
    public $timestamps = true;

    protected $fillable = [
        'asesi_id',
        'admin_id',
        'skema_id',
        'tgl_permohonan',
        'tujuan_asesmen',
        'status',
        'catatan'
    ];

    // ===============================
    // 🔗 RELASI ELOQUENT
    // ===============================

    /**
     * Asesi yang mengajukan permohonan ini
     */
    public function asesi()
    {
        return $this->belongsTo(Asesi::class, 'asesi_id', 'id_asesi');
    }

    /**
     * Admin yang memproses atau memverifikasi permohonan
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id_admin');
    }

    /**
     * Skema sertifikasi yang diajukan dalam permohonan ini
     */
    public function skema()
    {
        return $this->belongsTo(SkemaSertifikasi::class, 'skema_id', 'id_skema');
    }

    // ===============================
    // 🧩 OPTIONAL: ACCESSOR / MUTATOR
    // ===============================

    /**
     * Format tanggal agar tampil lebih mudah dibaca (opsional)
     */
    public function getTglPermohonanFormattedAttribute()
    {
        return $this->tgl_permohonan
            ? \Carbon\Carbon::parse($this->tgl_permohonan)->translatedFormat('d F Y')
            : null;
    }
}

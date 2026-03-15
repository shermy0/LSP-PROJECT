<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AsesmenMandiriMaster;

class Permohonan extends Model
{
    use HasFactory;

    // Sesuaikan dengan migration Anda
    protected $table = 'permohonan';
    protected $primaryKey = 'id_permohonan';
    public $incrementing = true;
    public $timestamps = true;

    // Gunakan nama kolom persis seperti pada migration/tabel
    protected $fillable = [
        'id_asesi',
        'id_admin',
        'id_skema',
        'id_tujuan',
        'tgl_permohonan',
        'status',
        'catatan',
    ];

    // Jika Anda ingin otomatis cast tanggal
    protected $dates = [
        'tgl_permohonan',
        'created_at',
        'updated_at',
    ];

    // ===============================
    // RELASI ELOQUENT (sesuaikan class target jika berbeda namespace)
    // ===============================

    public function asesi()
    {
        // Asesi model diasumsikan bernama Asesi dan primary key di tabel asesi adalah id_asesi
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }

    public function admin()
    {
        // Admin model diasumsikan bernama Admin dan primary key id_admin
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function skema()
    {
        // Skema model diasumsikan bernama SkemaSertifikasi dan pk id_skema
        return $this->belongsTo(SkemaSertifikasi::class, 'id_skema', 'id_skema');
    }

    // app/Models/Permohonan.php
    public function persetujuan()
    {
        return $this->hasOne(PersetujuanAsesmen::class, 'id_permohonan', 'id_permohonan');
    }

    public function asesmenMandiriMaster()
    {
        return $this->hasOne(AsesmenMandiriMaster::class, 'id_permohonan', 'id_permohonan');
    }

    public function penyesuaianWajar()
{
    return $this->hasOne(PenyesuaianWajar::class, 'id_permohonan', 'id_permohonan');
}

    // Accessor opsional untuk format tanggal
    public function getTglPermohonanFormattedAttribute()
    {
        return $this->tgl_permohonan
            ? \Carbon\Carbon::parse($this->tgl_permohonan)->translatedFormat('d F Y')
            : null;
    }
}
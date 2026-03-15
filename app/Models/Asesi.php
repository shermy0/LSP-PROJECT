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
        'jurusan_id', // TAMBAHKAN INI
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
     * Setiap Asesi memiliki satu Jurusan.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
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
        return $this->hasMany(Permohonan::class, 'id_asesi', 'id_asesi');
    }

    public function penyesuaianWajar()
{
    return $this->hasMany(PenyesuaianWajar::class, 'id_asesi', 'id_asesi');
}

    public function asesmenMandiriMaster()
{
    return $this->hasMany(AsesmenMandiriMaster::class, 'id_asesi', 'id_asesi');
}
    /**
     * Shortcut: ambil permohonan terakhir (terbaru).
     */
    public function permohonanTerakhir()
    {
        return $this->hasOne(Permohonan::class, 'id_asesi', 'id_asesi')->latestOfMany();
    }

    // ===============================
    // ⚡ SCOPE QUERY
    // ===============================

    /**
     * Scope untuk filter berdasarkan jurusan.
     */
    public function scopeByJurusan($query, $jurusanId)
    {
        return $query->where('jurusan_id', $jurusanId);
    }

    /**
     * Scope untuk filter berdasarkan status asesor.
     */
    public function scopeTanpaAsesor($query)
    {
        return $query->whereNull('asesor_id');
    }

    /**
     * Scope untuk filter berdasarkan asesor tertentu.
     */
    public function scopeDenganAsesor($query, $asesorId)
    {
        return $query->where('asesor_id', $asesorId);
    }

    // ===============================
    // 🔧 HELPER METHODS
    // ===============================

    /**
     * Cek apakah asesi sudah memiliki asesor.
     */
    public function memilikiAsesor(): bool
    {
        return !is_null($this->asesor_id);
    }

    /**
     * Get nama jurusan (helper).
     */
    public function getNamaJurusan(): ?string
    {
        return $this->jurusan ? $this->jurusan->nama_jurusan : null;
    }

    /**
     * Get kode jurusan (helper).
     */
    public function getKodeJurusan(): ?string
    {
        return $this->jurusan ? $this->jurusan->kode_jurusan : null;
    }

    /**
     * Format tanggal lahir.
     */
    public function getTanggalLahirFormatted(): string
    {
        return $this->tgl_lahir 
            ? \Carbon\Carbon::parse($this->tgl_lahir)->format('d/m/Y')
            : '-';
    }

    /**
     * Get usia berdasarkan tanggal lahir.
     */
    public function getUsia(): ?int
    {
        if (!$this->tgl_lahir) {
            return null;
        }
        
        return \Carbon\Carbon::parse($this->tgl_lahir)->age;
    }

    /**
     * Format jenis kelamin lengkap.
     */
    public function getJenisKelaminLengkap(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    /**
     * Get status penugasan asesor.
     */
    public function getStatusAsesor(): string
    {
        return $this->memilikiAsesor() 
            ? 'Sudah Ditugaskan' 
            : 'Belum Ditugaskan';
    }

    /**
     * Assign asesor ke asesi.
     */
    public function assignAsesor($asesorId): bool
    {
        $this->asesor_id = $asesorId;
        return $this->save();
    }

    /**
     * Remove asesor dari asesi.
     */
    public function removeAsesor(): bool
    {
        $this->asesor_id = null;
        return $this->save();
    }

    /**
     * Cek apakah asesi memiliki permohonan aktif.
     */
    public function memilikiPermohonanAktif(): bool
    {
        return $this->permohonan()
            ->whereIn('status', ['diproses', 'diterima', 'dalam_asesmen'])
            ->exists();
    }

    /**
     * Get permohonan aktif.
     */
    public function permohonanAktif()
    {
        return $this->permohonan()
            ->whereIn('status', ['diproses', 'diterima', 'dalam_asesmen'])
            ->first();
    }

    // ===============================
    // 🎯 ACCESSOR
    // ===============================

    /**
     * Accessor untuk nama lengkap dengan gelar (jika ada).
     */
    public function getNamaLengkapWithTitleAttribute()
    {
        return $this->nama_lengkap;
    }

    /**
     * Accessor untuk email atau email kantor.
     */
    public function getEmailUtamaAttribute()
    {
        return $this->email ?: $this->email_kantor;
    }

    /**
     * Accessor untuk telepon utama.
     */
    public function getTeleponUtamaAttribute()
    {
        return $this->telepon_hp ?: $this->telepon_rumah ?: $this->telepon_kantor;
    }
}
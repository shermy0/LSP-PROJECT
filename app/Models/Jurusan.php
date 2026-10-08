<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    public $timestamps = true;

    protected $fillable = [
        'kode_jurusan',
        'nama_jurusan',
        'deskripsi',
        'status',
    ];

    /**
     * Relasi ke Asesi.
     */
    public function asesis()
    {
        return $this->hasMany(Asesi::class, 'jurusan_id', 'id_jurusan');
    }

    /**
     * Relasi ke Asesor.
     */
    public function asesors()
    {
        return $this->hasMany(Asesor::class, 'id_jurusan', 'id_jurusan');
    }

    /**
     * Scope untuk jurusan aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Cek apakah jurusan aktif.
     */
    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Get jumlah asesi dalam jurusan ini.
     */
    public function getJumlahAsesiAttribute(): int
    {
        return $this->asesis()->count();
    }

    /**
     * Get jumlah asesor dalam jurusan ini.
     */
    public function getJumlahAsesorAttribute(): int
    {
        return $this->asesors()->count();
    }

    /**
     * Nonaktifkan jurusan.
     */
    public function nonaktifkan(): bool
    {
        $this->status = 'nonaktif';
        return $this->save();
    }

    /**
     * Aktifkan jurusan.
     */
    public function aktifkan(): bool
    {
        $this->status = 'aktif';
        return $this->save();
    }

    /**
     * Accessor untuk display jurusan.
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->kode_jurusan} - {$this->nama_jurusan}";
    }
}
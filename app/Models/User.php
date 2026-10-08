<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo', // tambahkan ini jika ada di migration
    ];

    // Kolom yang disembunyikan saat serialize (API/JSON)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting kolom otomatis
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel biodata sesuai role
    public function asesor()
    {
        return $this->hasOne(Asesor::class, 'user_id');
    }

    public function asesi()
    {
        return $this->hasOne(Asesi::class, 'user_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    // ========== HELPER METHODS ==========
    
    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah asesor
     */
    public function isAsesor(): bool
    {
        return $this->role === 'asesor';
    }

    /**
     * Cek apakah user adalah asesi
     */
    public function isAsesi(): bool
    {
        return $this->role === 'asesi';
    }

    /**
     * Get jurusan dari asesi (jika user adalah asesi)
     */
    public function jurusan()
    {
        // Hanya user dengan role asesi yang memiliki jurusan
        if (!$this->isAsesi()) {
            return null;
        }
        
        // Menggunakan relasi melalui asesi
        return $this->asesi ? $this->asesi->jurusan : null;
    }

    /**
     * Get nama jurusan (helper method)
     */
    public function getNamaJurusanAttribute(): ?string
    {
        $jurusan = $this->jurusan();
        return $jurusan ? $jurusan->nama_jurusan : null;
    }

    /**
     * Get kode jurusan (helper method)
     */
    public function getKodeJurusanAttribute(): ?string
    {
        $jurusan = $this->jurusan();
        return $jurusan ? $jurusan->kode_jurusan : null;
    }

    /**
     * Get nama lengkap asesi (jika ada)
     */
    public function getNamaLengkapAttribute(): ?string
    {
        if ($this->isAsesi() && $this->asesi) {
            return $this->asesi->nama_lengkap ?: $this->name;
        }
        
        if ($this->isAsesor() && $this->asesor) {
            return $this->asesor->nama_lengkap ?: $this->name;
        }
        
        return $this->name;
    }

    /**
     * Redirect berdasarkan role
     */
    public function getRedirectRoute(): string
    {
        return match($this->role) {
            'admin' => 'admin.dashboard',
            'asesor' => 'asesor.dashboard',
            'asesi' => 'asesi.dashboard',
            default => 'login',
        };
    }
}
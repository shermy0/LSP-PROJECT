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
        'role', // tambah role
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
}

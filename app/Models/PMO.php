<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMO extends Model
{
    use HasFactory;

    protected $table = 'pmo'; // sesuaikan dengan nama tabel di database
    protected $fillable = ['pertanyaan', 'persetujuan', 'tanggapan']; // isi kolom sesuai tabel
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    protected $table = 'dokumen_persyaratan'; // sesuaikan nama tabel
    protected $primaryKey = 'id_dokumen'; // sesuai di DB
    public $timestamps = false; // soalnya di tabel ga ada created_at/updated_at
}

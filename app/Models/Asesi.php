<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesi extends Model
{
    protected $table = 'asesi';
    protected $primaryKey = 'id_asesi';
    public $timestamps = true; // jika ada created_at/updated_at
    protected $fillable = ['nama_lengkap','alamat','telepon'];
}

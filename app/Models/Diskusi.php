<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model {
    use HasFactory;
    protected $table = 'diskusi';
    protected $primaryKey = 'id'; // ganti kalau primary key lain
    public $timestamps = false;
    protected $fillable = ['skema_id','id_validasi','nama_asesor','jabatan','hasil_diskusi'];
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilValidasi extends Model {
    use HasFactory;
    protected $table = 'hasil_validasi';
    protected $primaryKey = 'id'; // sesuaikan
    public $timestamps = false;
    protected $fillable = ['id_validasi','skema_id','user_id','keterangan','keterampilan','aspek','aturan_bukti','prinsip_asesmen'];
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcuanPembanding extends Model {
    use HasFactory;
    protected $table = 'acuan_pembanding';
    protected $primaryKey = 'id'; // sesuaikan
    public $timestamps = false;
    protected $fillable = ['id_validasi','skema_id','acuan','dokumen','acuan_lain','pembanding_lain'];
}
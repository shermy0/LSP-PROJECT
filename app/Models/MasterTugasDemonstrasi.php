<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTugasDemonstrasi extends Model
{
    protected $table = 'master_tugas_demonstrasi';
    protected $primaryKey = 'id_tugas'; // ✅ bukan id_tugas_demonstrasi
    public $timestamps = false;

    protected $fillable = [
        'id_demonstrasi',
        'id_skema',
        'id_asesor',
        'id_kelompok',
        'isi_pertanyaan_demonstrasi',
        'deskripsi_pertanyaan',
        'kunci_jawaban',
        'file_path',
        'file_type'
    ];



    public function demonstrasi()
    {
        return $this->belongsTo(Demonstrasi::class, 'id_demonstrasi', 'id_demonstrasi');
    }
}

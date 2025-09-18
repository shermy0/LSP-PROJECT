<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    use HasFactory;

    protected $table = 'umpan_balik';

    protected $fillable = [
        'id_skema',
        'id_asesor',
        'id_asesi',
        'nomor_skema',
        'tempat',
        'tanggal_mulai',
        'tanggal_selesai',
        'penjelasan_proses',
        'catatan_proses',
        'kesempatan_mempelajari',
        'catatan_mempelajari',
        'diskusi_metoda',
        'catatan_diskusi',
        'menggali_bukti',
        'catatan_bukti',
        'demonstrasi_kompetensi',
        'catatan_demonstrasi',
        'penjelasan_keputusan',
        'catatan_keputusan',
        'umpan_balik',
        'catatan_umpan_balik',
        'mempelajari_dokumen',
        'catatan_dokumen',
        'jaminan_rahasia',
        'catatan_rahasia',
        'komunikasi_efektif',
        'catatan_komunikasi',
        'catatan_lainnya',
    ];
    
}

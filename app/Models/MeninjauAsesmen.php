<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeninjauAsesmen extends Model
{
    use HasFactory;

    protected $table = 'meninjau_asesmen';
    protected $primaryKey = 'id_meninjau';

    protected $fillable = [
        'id_asesmen',
        'rencana_valid', 'rencana_reliabel', 'rencana_fleksibel', 'rencana_adil',
        'persiapan_valid', 'persiapan_reliabel', 'persiapan_fleksibel', 'persiapan_adil',
        'implementasi_valid', 'implementasi_reliabel', 'implementasi_fleksibel', 'implementasi_adil',
        'keputusan_valid', 'keputusan_reliabel', 'keputusan_fleksibel', 'keputusan_adil',
        'umpan_valid', 'umpan_reliabel', 'umpan_fleksibel', 'umpan_adil',
        'rekomendasi1',
        'konsistensi_task', 'konsistensi_task_mgmt', 'konsistensi_contingency', 'konsistensi_jobrole', 'konsistensi_transfer',
        'bukti_task', 'bukti_task_mgmt', 'bukti_contingency', 'bukti_jobrole', 'bukti_transfer',
        'rekomendasi2'
    ];
}

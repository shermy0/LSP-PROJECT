<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstrumenAsesmen;
use App\Models\LaporanAsesmen;
use App\Models\Skema;
use App\Models\Asesor;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'asesor_id' => 'required|exists:asesor,id_asesor',
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
        ]);

        LaporanAsesmen::create([
            'asesor_id' => $request->asesor_id,
            'skema_id' => $request->skema_id,
            'aspek_positif_negatif' => $request->aspek_positif_negatif,
            'penolakan' => $request->penolakan,
            'saran_perbaikan' => $request->saran_perbaikan,
            'tgl_laporan' => now(),
        ]);

        return redirect()->route('laporan_asesor')
            ->with('success','Laporan asesmen berhasil disimpan.');
    }
}

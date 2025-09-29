<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skema;
use App\Models\Asesi;

class LaporanController extends Controller
{
    // tampilkan laporan per skema
    public function showLaporan($skema_id)
    {
        $skema = Skema::findOrFail($skema_id);

        // ambil asesor yang terkait skema ini lewat tabel pivot asesor_skema
        $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.*')
            ->get();

        return view('laporan', compact('skema', 'asesors'));
    }

public function showLaporanAsesor($skema_id)
{
    $skema = Skema::findOrFail($skema_id);

    $asesors = DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skema_id)
        ->select('asesor.*')
        ->get();

    // $laporans = LaporanAsesmen::with('asesor')->where('skema_id', $skema_id)->get();

    return view('laporan_asesor', compact('skema', 'asesors'));
}


    

    // ambil data asesi sesuai asesor & skema
public function getAsesiByAsesor($skema_id, $asesor_id)
{
    $asesis = DB::table('asesi')
        ->where('asesi.asesor_id', $asesor_id)
        ->get();

    return response()->json($asesis);
}

    // simpan catatan asesmen
public function store(Request $request)
{
    // simpan data laporan di tabel laporan_asesmen / hasil_laporan
    // contoh dummy:
    // LaporanAsesmen::create([
    //     'skema_id'       => $request->skema_id,
    //     'asesor_id'      => $request->asesor_id,
    //     'no_registrasi'  => $request->no_registrasi,
    //     'aspek_positif_negatif' => $request->aspek_positif_negatif,
    //     'penolakan'      => $request->penolakan,
    //     'saran_perbaikan'=> $request->saran_perbaikan,
    // ]);

    return redirect()->route('laporan.asesor', $request->skema_id)
        ->with('success', 'Laporan berhasil disimpan');
}

    
}

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

        return view('form_perencanaan.laporan_asesmen.laporan', compact('skema', 'asesors'));
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

    return view('form_perencanaan.laporan_asesmen.laporan_asesor', compact('skema', 'asesors'));
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
    $skemaId = $request->skema_id;
    $asesorId = $request->asesor_id;

    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'rekomendasi_')) {
            $asesiId = explode('_', $key)[1];
            $hasil   = $value;
            $unitId  = $request->input("keterangan_$asesiId");

            \DB::table('hasil_unit_kompetensi')->insert([
                'id_asesi' => $asesiId,
                'id_unit'  => $unitId ?? 0,
                'hasil'    => $hasil,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    return redirect()->route('form_perencanaan.laporan_asesmen.laporan.asesor', $skemaId)
        ->with('success', 'Laporan berhasil disimpan');
}
    
}

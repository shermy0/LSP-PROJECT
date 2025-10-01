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
        ->leftJoin('hasil_unit_kompetensi', 'asesi.id_asesi', '=', 'hasil_unit_kompetensi.id_asesi')
        ->where('asesi.asesor_id', $asesor_id)
        ->select(
            'asesi.id_asesi',
            'asesi.nama_lengkap',
            'hasil_unit_kompetensi.hasil',
            'hasil_unit_kompetensi.id_unit'
        )
        ->get();

    $catatan = DB::table('laporan_asesmen')
        ->where('skema_id', $skema_id)
        ->where('asesor_id', $asesor_id)
        ->first();

    return response()->json([
        'asesis'  => $asesis,
        'catatan' => $catatan,
    ]);
}


    // simpan catatan asesmen
public function store(Request $request)
{
    $skemaId  = $request->skema_id;
    $asesorId = $request->asesor_id;

    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'rekomendasi_')) {
            $asesiId = explode('_', $key)[1];
            $hasil   = $value;
            $unitId  = $request->input("keterangan_$asesiId");

            if ($hasil === 'BK' && empty($unitId)) {
                return back()->withErrors("Asesi $asesiId wajib pilih unit jika BK");
            }

            DB::table('hasil_unit_kompetensi')->updateOrInsert(
                ['id_asesi' => $asesiId],
                [
                    'id_unit'    => $hasil === 'K' ? null : $unitId,
                    'hasil'      => $hasil,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    DB::table('laporan_asesmen')->updateOrInsert(
        [
            'skema_id'  => $skemaId,
            'asesor_id' => $asesorId,
        ],
        [
            'aspek_positif_negatif' => $request->input('aspek_positif_negatif'),
            'penolakan'             => $request->input('penolakan'),
            'saran_perbaikan'       => $request->input('saran_perbaikan'),
            'tgl_laporan'           => now(),
            'updated_at'            => now(),
            'created_at'            => now(),
        ]
    );

    return redirect()
        ->route('form_perencanaan.laporan_asesmen.laporan_asesor', $skemaId)
        ->with('success', 'Laporan berhasil disimpan')
        ->with('asesor_terpilih', $asesorId);
}    
}

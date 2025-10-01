<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\UnitKompetensi;
use App\Models\HasilAsesmen;
use App\Models\HasilAsesmenBukti;
use App\Models\HasilAsesmenPerangkat;
use App\Models\MasterJenisBukti;
use App\Models\PerangkatAsesmen;
use App\Models\KelompokPekerjaan;
use App\Models\InstrumenAsesmen;
use Illuminate\Support\Facades\DB;

class Mapa02Controller extends Controller
{
    // Halaman MAPA02 default (tampilkan semua skema)
    public function index()
    {
        $skemas = Skema::all();
        return view('form_perencanaan.form_mapa_02.mapa02', compact('skemas'));
    }

    // Halaman MAPA02 berdasarkan skema
    public function showMapa02($skema_id)
    {
        $skema = Skema::findOrFail($skema_id);

        $kelompokPekerjaan = KelompokPekerjaan::with([
                'hasilAsesmen.unit',
                // 'hasilAsesmen.bukti.jenisBukti',
                // 'hasilAsesmen.perangkat.perangkat'
            ])
            ->where('id_skema', $skema_id)
            ->get();

        return view('form_perencanaan.form_mapa_02.mapa02', compact('skema', 'kelompokPekerjaan'));
    }

    // Ambil data asesor berdasarkan skema (AJAX)
    public function getAsesor($skemaId)
    {
        $skema = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
        if (!$skema) return response()->json([]);

        $asesors = DB::table('asesor')
            ->where('bidang_keahlian', $skema->bidang_keahlian)
            ->select('id_asesor', 'nama_asesor', 'no_registrasi')
            ->get();

        return response()->json($asesors);
    }

    // Ambil data asesi berdasarkan skema dan asesor (AJAX)
    public function getAsesi($skemaId, $asesorId)
    {
        $asesi = DB::table('asesi')
            ->where('asesor_id', $asesorId)
            ->select('id_asesi', 'nama_lengkap')
            ->get();

        return response()->json($asesi);
    }

public function simpanInstrumen(Request $request)
{
    $skemaId = $request->skema_id;
    $asesorId = auth()->user()->asesor->id_asesor ?? null;

    if (!$asesorId) {
        return back()->with('error', 'Asesor tidak ditemukan.');
    }

    if ($request->has('potensi')) {
        foreach ($request->potensi as $instrumenId => $value) {
            DB::table('asesmen_instrumen_jawaban')->insert([
                'skema_id'     => $skemaId,
                'instrumen_id' => $instrumenId,
                'asesor_id'    => $asesorId,
                'potensi'      => $value,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }

return redirect()->route('form.mapa02.asesor', ['skema_id' => $skemaId])
                 ->with('success', 'Instrumen berhasil disimpan');
}


    
public function showMapa02Asesor($id_skema)
{
    $skema = Skema::findOrFail($id_skema);
    $asesors = DB::table('asesor')->get();

    return view('mapa02_asesor', compact('skema', 'asesors'));
}




    // Ambil unit per skema (AJAX)
    public function getUnits($skemaId)
    {
        $units = UnitKompetensi::where('skema_id', $skemaId)->get();
        return response()->json($units);
    }
}

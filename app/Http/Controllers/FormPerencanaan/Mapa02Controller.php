<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\InstrumenAsesmen;
use App\Models\UnitKompetensi;
use Illuminate\Support\Facades\DB;

class Mapa02Controller extends Controller
{
    // Halaman MAPA02 default (tampilkan semua skema)
    public function index()
    {
        $skemas = Skema::all();
        return view('mapa02', compact('skemas'));
    }

    // Halaman MAPA02 berdasarkan skema
    public function showMapa02($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        // Ambil instrumen yang terkait dengan skema ini
        $instrumen = InstrumenAsesmen::where('skema_id', $id_skema)->get();

        // Ambil unit per skema
        // $units = UnitKompetensi::where('skema_id', $id_skema)->get();

        // Placeholder untuk kelompok pekerjaan (kalau nanti dipakai)
        $kelompokPekerjaan = collect();

        return view('mapa02', compact('skema', 'instrumen', 'kelompokPekerjaan'));
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

    // Simpan jawaban instrumen MAPA02
    public function simpanInstrumen(Request $request)
    {
        $skemaId = $request->skema_id;
        $asesorId = auth()->user()->asesor->id_asesor ?? null;

        if (!$asesorId) {
            return back()->with('error', 'Asesor tidak ditemukan.');
        }

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

        return back()->with('success', 'Instrumen berhasil disimpan');
    }

    // Ambil unit per skema (AJAX)
    public function getUnits($skemaId)
    {
        $units = UnitKompetensi::where('skema_id', $skemaId)->get();
        return response()->json($units);
    }
}

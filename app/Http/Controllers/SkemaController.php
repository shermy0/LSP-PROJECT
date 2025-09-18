<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use App\Models\InstrumenAsesmen;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SkemaController extends Controller
{
    // laporan
    public function laporan(Request $request)
    {
        $skemas = Skema::with('units')->get();

        $selectedSkema = $request->input('skema_id');
        $asesors = collect();

        if ($selectedSkema) {
            $skema = DB::table('skema_sertifikasi')->where('id', $selectedSkema)->first();

            if ($skema) {
                $asesors = DB::table('asesor')
                    ->where('bidang_keahlian', $skema->bidang_keahlian)
                    ->select('id_asesor', 'nama_asesor')
                    ->get();
            }
        }

        return view('laporan', compact('skemas', 'asesors', 'selectedSkema'));
    }
    
    // Relasi Skema ke Unit Kompetensi
    public function units()
    {
        return $this->hasMany(UnitKompetensi::class, 'skema_id', 'id_skema');
    }

    // Meninjau Asesmen yang Menampilkan semua skema
    public function ninjau_asesemen() 
    {
        $skemas = Skema::all();
        return view('ninjau_asesemen', compact('skemas'));
    }
    
    // Halaman MAPA 02 yang Menampilkan semua skema
    public function mapa02()
    {
        $skemas = Skema::all(); 
        return view('mapa02', compact('skemas'));
    }
    
    public function show($id)
    {
        // ambil data dari mapa02
        $mapa02 = DB::table('mapa02')->where('id_mapa02', $id)->first();
    
        // kalau ada skema_id, ambil skema dari model Skema
        $currentSkemaId = $mapa02->skema_id ?? null;
    
        return view('ninjau_asesmen', [
            'skemas'         => Skema::all(),
            'currentSkemaId' => $currentSkemaId,
            'skema'          => $currentSkemaId ? Skema::find($currentSkemaId) : null,
        ]);
    }

    public function showForm()
    {
        $skemas = Skema::with('units')->get();
        $instrumen = InstrumenAsesmen::all();

        return view('mapa02', compact('skemas', 'instrumen'));
    }

    // Ambil data Asesor berdasarkan skema
    public function getAsesor($skemaId)
    {
        $skema = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
        if (!$skema) return response()->json([]);

        $asesors = DB::table('asesor')
            ->where('bidang_keahlian', $skema->bidang_keahlian)
            ->select('id_asesor', 'nama_asesor', 'no_registrasi')
            ->get();    

        \Log::info($asesors);

        return response()->json($asesors);
    }

    // Ambil data Asesi berdasarkan skema dan asesor
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
        $asesorId = auth()->user()->asesor->id_asesor; // asumsi relasi user → asesor

        foreach ($request->potensi as $instrumenId => $value) {
            DB::table('asesmen_instrumen_jawaban')->insert([
                'skema_id' => $skemaId,
                'instrumen_id' => $instrumenId,
                'asesor_id' => $asesorId,
                'potensi' => $value,
            ]);
        }

        return back()->with('success', 'Instrumen berhasil disimpan');
    }

    public function getUnits($skemaId) {
        $units = UnitKompetensi::where('skema_id', $skemaId)->get();
        return response()->json($units);
    }    
}
<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkemaController extends Controller
{
    public function laporan()
    {
        $skemas = Skema::all();
        return view('laporan_asesmen.laporan', compact('skemas'));
    }    

    public function mapa02()
    {
        $skemas = Skema::all(); 
        return view('mapa02.mapa02', compact('skemas'));
    }
    public function frak3()
    {
        $skemas = Skema::all();
        return view('frak3', compact('skemas')); // resources/views/frak3.blade.php
    }

    public function simpanFrak3(Request $request)
    {
        // logika simpan ke database
        // contoh: Frak3::create($request->all());

        return redirect()->route('frak3')->with('success', 'FR.AK.03 berhasil disimpan!');
    }
    public function ninjau_asesemen()
    {
        $skemas = Skema::all(); 
        return view('meninjau_asesmen/ninjau_asesemen', compact('skemas'));
    }
    public function formMapa01()
    {
        $skemas = Skema::all();
        return view('form_perencanaan.form_mapa_01.mapa01', compact('skemas'));
    }
    public function getAsesor($skema_id)
    {
        $asesors = DB::table('asesor_skema')
            ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        return response()->json($asesors);
    }
}
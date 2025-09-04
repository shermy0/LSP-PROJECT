<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;

class SkemaController extends Controller
{
    public function laporan()
    {
        $skemas = Skema::all();
        return view('laporan_asesmen.laporan', compact('skemas'));
    }    
    
    public function ninjau_asesemen() 
    {
        $skemas = Skema::all();
        return view('meninjau_asesmen.ninjau_asesemen', compact('skemas'));
    }
    
    public function mapa02()
    {
        $skemas = Skema::all(); 
        return view('mapa02.mapa02', compact('skemas'));
    }
    public function frak3()
    {
        $skemas = Skema::all(); // kalau mau nampilin data skema
        return view('frak3', compact('skemas')); // arah ke resources/views/frak3.blade.php
    }

    public function simpanFrak3(Request $request)
    {
        // logika simpan ke database
        // contoh: Frak3::create($request->all());

        return redirect()->route('frak3')->with('success', 'FR.AK.03 berhasil disimpan!');
    }
}

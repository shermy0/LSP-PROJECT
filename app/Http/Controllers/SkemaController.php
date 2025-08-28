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

}
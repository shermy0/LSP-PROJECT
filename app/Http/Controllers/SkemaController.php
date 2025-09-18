<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;

class SkemaController extends Controller
{
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

}
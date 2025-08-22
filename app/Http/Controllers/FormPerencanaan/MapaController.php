<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use App\Models\SkemaSertifikasi;
use Illuminate\Http\Request;

class MapaController extends Controller
{
    public function create()
    {
        $skema = SkemaSertifikasi::where('status_skema', 'Aktif')->get();
        return view('form_perencanaan.mapa01', compact('skema'));
    }

    public function getSkema($id)
    {
        $skema = SkemaSertifikasi::findOrFail($id);
        return response()->json($skema);
    }
}

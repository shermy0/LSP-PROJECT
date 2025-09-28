<?php

namespace App\Http\Controllers;

use App\Models\Asesi;
use App\Models\Asesor;
use Illuminate\Http\Request;

class PilihAsesorController extends Controller
{
    public function index()
    {
        $asesis = Asesi::with('asesor')->get();
        $asesors = Asesor::all();

        return view('admin.pilih_asesor', compact('asesis', 'asesors'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'asesi_id' => 'required|exists:asesi,id_asesi',
        'asesor_id' => 'required|exists:asesor,id_asesor',
      ]);


        $asesi = Asesi::findOrFail($request->id_asesi);
        $asesi->asesor_id = $request->asesor_id;
        $asesi->save();

        return redirect()->back()->with('success', 'Asesor berhasil ditetapkan untuk asesi.');
    }
}

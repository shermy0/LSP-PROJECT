<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerencanaanController extends Controller
{
    public function index()
    {
        return view('formperencanaan'); 
    }

    public function simpan(Request $request)
    {
        // logika simpan data ke DB di sini
        return redirect()->route('formperencanaan')
            ->with('success', 'Data berhasil disimpan!');
    }

    public function simpanLanjut(Request $request)
    {
        // validasi misalnya $request->asesor_id ada
        return redirect()->route('ninjau_asesmen_asesor.view', [
            'asesor_id' => $request->asesor_id,
        ])->with('success', 'Data berhasil disimpan dan dilanjutkan!');
    }

    public function ninjauAsesmenAsesor(Request $request)
    {
        $asesor_id = $request->route('asesor_id');
        $asesor = DB::table('asesor')->where('id_asesor', $asesor_id)->first();
        return view('meninjau_asesmen.ninjau_asesmen_asesor', compact('asesor'));
    }
}

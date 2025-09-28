<?php

namespace App\Http\Controllers;

use App\Models\Penyusun;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\Asesor;

class PenyusunController extends Controller
{
    public function create()
    {
        $skema = Skema::first();     
        $asesor = Asesor::first(); 

        return view('laporan_asesor', compact('skema','asesor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asesor_id'     => 'nullable|integer',
            'skema_id'      => 'nullable|integer',
            'no_registrasi' => 'required|string',
            'tgl_laporan'   => 'required|date',
            'tanda_tangan'  => 'required',
            'catatan'       => 'required|string',
        ]);

        Penyusun::create([
            'id_asesor'    => $request->asesor_id,
            'id_skema'     => $request->skema_id,
            'no_met'       => $request->no_registrasi,
            'tanggal'      => $request->tgl_laporan,
            'tanda_tangan' => $request->tanda_tangan,
            'catatan'      => $request->catatan,
        ]);

        return view('formperencanaan')->with('success', 'Data berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumenController extends Controller
{
    public function simpanPotensi(Request $request)
    {
        $validated = $request->validate([
            'skema_id' => 'required',
            'skema_sertifikasi' => 'required',
            'nomor' => 'required',
            'potensi' => 'array'
        ]);

        // simpan ke tabel utama
        $mapa02 = Mapa02::create([
            'skema_id' => $validated['skema_id'],
            'skema_sertifikasi' => $validated['skema_sertifikasi'],
            'nomor' => $validated['nomor'],
        ]);

        // simpan potensi instrumen
        foreach ($validated['potensi'] as $id_instrumen => $nilai) {
            InstrumenPotensi::create([
                'mapa02_id' => $mapa02->id,
                'instrumen_id' => $id_instrumen,
                'nilai' => $nilai,
            ]);
        }

        return redirect()->route('mapa02')->with('success','Data berhasil disimpan!');
    }
}

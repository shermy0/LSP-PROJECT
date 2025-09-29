<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class EvaluasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'isi_pertanyaan.*' => 'required|string',
            'tanggapan.*' => 'nullable|string',
            'jawaban.*' => 'nullable|string',
        ]);

        // Ambil data
        $pertanyaan = $request->input('isi_pertanyaan');
        $tanggapan = $request->input('tanggapan');
        $jawaban = $request->input('jawaban');

        // Contoh simpan ke DB (sesuaikan tabelmu)
        foreach($pertanyaan as $i => $p) {
            \DB::table('evaluasi')->insert([
                'isi_pertanyaan' => $p,
                'tanggapan' => $tanggapan[$i] ?? null,
                'jawaban' => $jawaban[$i] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Evaluasi berhasil disimpan');
    }
}

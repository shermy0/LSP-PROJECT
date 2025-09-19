<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan; // pastikan sudah bikin model & migration

class Fria05aAsesiController extends Controller
{
    public function index()
    {
        $pertanyaan = Pertanyaan::orderBy('id')->get();
        return view('fria05aASesi', compact('pertanyaan'));
    }

    public function store(Request $request)
    {
        // simpan jawaban
        foreach ($request->jawaban as $id => $jawaban) {
            // contoh simpan ke tabel jawaban_asesi
            \DB::table('jawaban_asesi')->insert([
                'pertanyaan_id' => $id,
                'jawaban' => $jawaban,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('fria05aAsesi')->with('success', 'Jawaban berhasil disimpan!');
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class Fria05aController extends Controller
{
    // STEP 1: halaman awal (fria05a.blade.php)
    public function index()
    {
        return view('fria05a');
    }

    // STEP 2: halaman review soal (fria05a1.blade.php)
    public function step1()
    {
        return view('fria05a1');
    }

    // STEP 3: halaman finalisasi soal (fria05a2.blade.php)
    public function step2()
    {
        return view('fria05a2');
    }

    // STEP 4: tambah asesor (tambahasesor.blade.php)
    public function tambahAsesor()
    {
        return view('tambahasesor');
    }

    // SIMPAN pertanyaan ke DB
    public function store(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'pertanyaan_') === 0) {
                $index = explode('_', $key)[1];

                $pertanyaan = new Pertanyaan();
                $pertanyaan->pertanyaan = $request->input("pertanyaan_$index");
                $pertanyaan->save();
            }
        }

        return redirect()->back()->with('success', 'Pertanyaan berhasil disimpan!');
    }
}

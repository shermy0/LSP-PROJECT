<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;

class DaftarSkemaController extends Controller
{
    // tampilkan semua skema
    public function index()
    {
        $skema = Skema::select('id_skema', 'nama_skema', 'kode_skema', 'jenjang')->get();

        return view('daftar_skema.index', compact('skema'));
    }

    // tampilkan detail skema yg dipilih
    public function show($id)
    {
        $skema = Skema::where('id_skema', $id)
                      ->select('id_skema', 'nama_skema', 'kode_skema', 'jenjang')
                      ->firstOrFail();

        return view('daftar_skema.show', compact('skema'));
    }
}

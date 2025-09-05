<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

class FormAsesmenController extends Controller
{
    public function index()
    {
        // ambil data dari DB
        $skema = Skema::orderBy('nama_skema', 'asc')->get();

        return view('formasesmen', compact('skema'));
    }

    public function pertanyaanEsai($id_skema)
{
    // cari skema berdasarkan ID
    $skema = Skema::findOrFail($id_skema);

    return view('essai', compact('skema'));
}
}


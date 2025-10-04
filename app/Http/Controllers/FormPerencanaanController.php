<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

class FormPerencanaanController extends Controller
{
    // Halaman daftar skema
    public function index()
    {
        $skema = Skema::all();
        return view('perencanaan_daftar_skema', compact('skema'));
    }

    // Halaman form perencanaan sesuai skema
    public function show($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        // kirim juga id_skema ke view
        return view('formperencanaan', [
            'skema' => $skema,
            'id_skema' => $id_skema,
        ]);
    }
}

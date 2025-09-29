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
        return view('formperencanaan', compact('skema'));
    }
}
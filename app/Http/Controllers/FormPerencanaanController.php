<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

class FormPerencanaanController extends Controller
{
    // Halaman daftar skema
    public function index()
    {
        $skema = Skema::all(); // Model Skema untuk tabel skema_sertifikasi
        return view('perencanaan_daftar_skema', compact('skema'));
    }

    // Halaman daftar form sesuai skema yang dipilih
    public function show($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);
        return view('formperencanaan', compact('skema'));
    }
}

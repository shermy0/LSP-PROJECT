<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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

    // ambil jenis pertanyaan unik untuk skema ini
    $jenis_pertanyaan = DB::table('pembuatan_pertanyaan')
        ->where('id_skema', $id_skema)
        ->distinct()
        ->pluck('jenis_pertanyaan')
        ->toArray();

    $semuaJenis = ['pilihan_ganda','esai','lisan'];

    // cek apakah ketiga jenis soal sudah ada
    $laporanBisaDibuka = collect($semuaJenis)
        ->every(fn($jenis) => in_array($jenis, $jenis_pertanyaan));

    // jenis pertanyaan yang kurang
    $jenisKurang = collect($semuaJenis)
        ->diff($jenis_pertanyaan)
        ->values()
        ->toArray();

    return view('formperencanaan', compact('skema', 'laporanBisaDibuka', 'jenisKurang'));
}

}

<?php

namespace App\Http\Controllers;

use App\Models\PersetujuanAsesmen;
use App\Models\Bukti;
use App\Models\Tuk;
use Illuminate\Http\Request;

class KerahasiaanController extends Controller
{
    public function create()
    {
        // ambil persetujuan pertama + relasinya
       $persetujuan = PersetujuanAsesmen::with(['asesi', 'asesor', 'skema', 'tuk'])->first();
        dd($persetujuan);


        // ambil semua bukti
        $bukti = Bukti::all();

        // ambil semua TUK
        $tuk = Tuk::all();

        return view('kerahasiaan', compact('persetujuan', 'bukti', 'tuk'));
    }

    public function store(Request $request)
    {
        // nanti isi logic simpan data
    }
}

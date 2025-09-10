<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BandingAsesmenController extends Controller
{
    public function index()
    {
        return view('banding-asesmen');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_asesi' => 'required|string',
            'nama_asesor' => 'required|string',
            'tanggal_asesmen' => 'required|date',
            'proses_dijelaskan' => 'required',
            'diskusi_asesor' => 'required',
            'melibatkan_orang' => 'required',
            'skema' => 'required|string',
            'no_skema' => 'required|string',
            'alasan' => 'required|string',
            'nama_lengkap' => 'required|string',
            'tanggal' => 'required|date'
        ]);

        // Simpan ke database kalau model sudah siap
        // BandingAsesmen::create($request->all());

        return redirect()->back()->with('success', 'Form berhasil dikirim!');
    }
}

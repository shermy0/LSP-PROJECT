<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesor; // pastikan model Asesor ada
use Illuminate\Support\Facades\Auth;

class BandingAsesmenController extends Controller
{
    // Halaman utama form banding asesmen
    public function index(Request $request)
    {
        $asesors = Asesor::all();

        // Data dari session
        $namaAsesor = session('asesor');
        $tanggalAsesmen = session('tanggal');

        // Nama asesi dari user yang login
        $namaAsesi = Auth::user()->name ?? null;

        return view('banding-asesmen', compact(
            'asesors',
            'namaAsesi',
            'namaAsesor',
            'tanggalAsesmen'
        ));
    }

    // Simpan data form banding asesmen
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

        // Kalau model BandingAsesmen sudah ada:
        // BandingAsesmen::create($request->all());

        return redirect()->back()->with('success', 'Form berhasil dikirim!');
    }

    // Simpan pilihan asesor & tanggal dari halaman sebelumnya
    public function simpanAsesor(Request $request)
    {
        session([
            'asesor' => $request->asesor,
            'tanggal' => $request->tanggal
        ]);

        return redirect()->route('banding.asesmen');
    }
}

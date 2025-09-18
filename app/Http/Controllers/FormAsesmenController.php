<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\PembuatanPertanyaan;
class FormAsesmenController extends Controller
{
    public function index()
    {
        // ambil data dari DB
        $skema = Skema::orderBy('nama_skema', 'asc')->get();

        return view('formasesmen', compact('skema'));
    }

    public function pramuniaga()
    {
        // kalo cuma mau nampilin view
        return view('pramuniaga'); 
    }

    public function officeadministative()
    {
        // kalo cuma mau nampilin view
        return view('officeadministative'); 
    }

    public function pemogramanjunior()
    {
        // kalo cuma mau nampilin view
        return view('pemogramanjunior'); 
    }

    public function juniortechnicalsupport()
    {
        // kalo cuma mau nampilin view
        return view('juniortechnicalsupport'); 
    }


     public function junioroperatordesigngrafis()
    {
        // kalo cuma mau nampilin view
        return view('junioroperatordesigngrafis'); 
    }

     public function akuntansikeuanganII()
    {
        // kalo cuma mau nampilin view
        return view('akuntansikeuanganII'); 
    }
    public function pertanyaanEsai()
    {
       // arahkan ke essai.blade.php
        return view('essai');
    }

    public function storeEsai(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'nullable|string'
        ]);

        PertanyaanEsai::create([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban
        ]);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan');
    }

    public function deleteEsai(Request $request)
    {
        PertanyaanEsai::destroy($request->id);
        return back()->with('success', 'Pertanyaan berhasil dihapus');
    }
}

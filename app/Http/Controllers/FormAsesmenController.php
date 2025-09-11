<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\PertanyaanEsai;


class FormAsesmenController extends Controller
{
    // Method index tetap seperti ini
    public function index()
    {
        $skema = Skema::all();
        return view('formasesmen', compact('skema'));
    }

    // Method untuk halaman pertanyaan esai per skema
    public function pertanyaanEsai($id_skema)
    {
        // Ambil skema berdasarkan id
        $skema = Skema::findOrFail($id_skema);

        // Ambil semua pertanyaan esai terkait skema ini
        $pertanyaanEsai = PertanyaanEsai::where('id_skema', $id_skema)->get();

        // Kirim ke view pertanyaanEsai.blade.php
        return view('pertanyaanEsai', compact('skema', 'pertanyaanEsai'));
    }

    // Method lainnya tetap
    public function pramuniaga()
    {
        return view('pramuniaga'); 
    }

    public function officeadministative()
    {
        return view('officeadministative'); 
    }

    public function pemogramanjunior()
    {
        return view('pemogramanjunior'); 
    }

    public function juniortechnicalsupport()
    {
        return view('juniortechnicalsupport'); 
    }

    public function junioroperatordesigngrafis()
    {
        return view('junioroperatordesigngrafis'); 
    }

    public function akuntansikeuanganII()
    {
        return view('akuntansikeuanganII'); 
    }
}
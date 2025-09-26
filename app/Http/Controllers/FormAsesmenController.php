<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
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
=======

class FormAsesmenController extends Controller
{
     public function index()
    {
        // kalo cuma mau nampilin view
        return view('formasesmen'); 
    }

    public function pramuniaga()
    {
        // kalo cuma mau nampilin view
>>>>>>> fc23860cdc99f1db4e1288cbb020fa4d4abcd33f
        return view('pramuniaga'); 
    }

    public function officeadministative()
    {
<<<<<<< HEAD
=======
        // kalo cuma mau nampilin view
>>>>>>> fc23860cdc99f1db4e1288cbb020fa4d4abcd33f
        return view('officeadministative'); 
    }

    public function pemogramanjunior()
    {
<<<<<<< HEAD
=======
        // kalo cuma mau nampilin view
>>>>>>> fc23860cdc99f1db4e1288cbb020fa4d4abcd33f
        return view('pemogramanjunior'); 
    }

    public function juniortechnicalsupport()
    {
<<<<<<< HEAD
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
=======
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
}
>>>>>>> fc23860cdc99f1db4e1288cbb020fa4d4abcd33f

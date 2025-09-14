<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormAsesmenController extends Controller
{
     public function asesi()
    {
        // kalo cuma mau nampilin view
        return view('asesi.formasesmen'); 
    }

    public function pramuniaga()
    {
        // kalo cuma mau nampilin view
        return view('asesi.pramuniaga'); 
    }

    public function officeadministative()
    {
        // kalo cuma mau nampilin view
        return view('asesi.officeadministative'); 
    }

    public function pemogramanjunior()
    {
        // kalo cuma mau nampilin view
        return view('asesi.pemogramanjunior'); 
    }

    public function juniortechnicalsupport()
    {
        // kalo cuma mau nampilin view
        return view('asesi.juniortechnicalsupport'); 
    }


     public function junioroperatordesigngrafis()
    {
        // kalo cuma mau nampilin view
        return view('asesi.junioroperatordesigngrafis'); 
    }

     public function akuntansikeuanganII()
    {
        // kalo cuma mau nampilin view
        return view('asesi.akuntansikeuanganII'); 
    }
    
    public function pertanyaanEsai()
    {
       // arahkan ke essai.blade.php
        return view('asesi/essai');
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
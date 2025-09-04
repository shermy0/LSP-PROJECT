<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}

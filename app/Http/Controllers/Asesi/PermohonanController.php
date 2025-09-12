<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;

class PermohonanController extends Controller
{
    public function form1()
    {
        return view('asesi.permohonan.form1');
    }

    public function form2()
    {
        return view('asesi.permohonan.form2');
    }

    public function form3()
    {
        return view('asesi.permohonan.form3');
    }

    public function form4()
    {
        return view('asesi.permohonan.form4');
    }

    public function form5()
    {
        return view('asesi.permohonan.form5');
    }
}

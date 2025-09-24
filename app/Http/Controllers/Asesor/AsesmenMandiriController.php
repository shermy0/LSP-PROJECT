<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsesmenMandiriController extends Controller
{
    public function form1()
    {
        return view('asesor.asesmen_mandiri.form1');
    }

    public function form2()
    {
        return view('asesor.asesmen_mandiri.form2');
    }

    public function form3()
    {
        return view('asesor.asesmen_mandiri.form3');
    }
}

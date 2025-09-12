<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;

class WajarAlasanController extends Controller
{
    public function form1() {
        return view('asesor.wajar_alasan.form1');
    }

    public function form2() {
        return view('asesor.wajar_alasan.form2');
    }

    public function form3() {
        return view('asesor.wajar_alasan.form3');
    }

}

<?php

namespace App\Http\Controllers\Asesi;

use App\Http\Controllers\Controller;

class WajarAlasanController extends Controller
{
    public function form1() {
        return view('asesi.wajar_alasan.form1');
    }

    public function form2() {
        return view('asesi.wajar_alasan.form2');
    }

    public function form3() {
        return view('asesi.wajar_alasan.form3');
    }
}


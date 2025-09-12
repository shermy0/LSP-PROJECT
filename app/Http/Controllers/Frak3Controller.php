<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Frak3Controller extends Controller
{
    public function index()
    {
        return view('frak3'); 
    }

    public function simpan(Request $request)
    {
        return redirect()->route('frak3.index')->with('success', 'Data FR.AK.03 berhasil disimpan!');
    }
}

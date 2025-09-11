<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Frak3Controller extends Controller
{
    public function index()
    {
        return view('frak3'); // pastikan file blade kamu namanya frak3.blade.php
    }

    public function simpan(Request $request)
    {
        // buat cek dulu datanya masuk atau belum
        // dd($request->all());

        // nanti bisa lanjut simpan ke database
        return redirect()->route('frak3.index')->with('success', 'Data FR.AK.03 berhasil disimpan!');
    }
}

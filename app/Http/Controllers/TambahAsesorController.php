<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TambahAsesorController extends Controller
{
    /**
     * Tampilkan halaman tambah asesor
     */
    public function index()
    {
        // Tidak perlu data awal, cukup return view
        return view('tambahasesor');
    }
}

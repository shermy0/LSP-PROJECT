<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerencanaanController extends Controller
{
    public function index()
    {
        return view('formperencanaan'); 
    }

    public function simpan(Request $request)
    {
        // logika simpan data ke DB di sini
        return redirect()->route('formperencanaan')
            ->with('success', 'Data berhasil disimpan!');
    }

    public function simpanLanjut(Request $request)
    {
        return redirect()->route('ninjau_asesmen_asesor')
            ->with('success', 'Data berhasil disimpan dan dilanjutkan!');
    }

    public function simpanLanjutLaporan(Request $request)
    {
        return redirect()->route('laporan_asesor')
            ->with('success', 'Data berhasil disimpan dan lanjut ke laporan!');
    }
    
    public function simpanLanjutmapa02(Request $request)
    {
        return redirect()->route('mapa02_asesor.show')
            ->with('success', 'Data berhasil disimpan dan lanjut ke MAPA 02 Asesor!');
    }
    

    public function laporan() 
    {
        return view('laporan_asesmen.laporan_asesor');
    }

    public function ninjauAsesmenAsesor() 
    {
        return view('meninjau_asesmen.ninjau_asesmen_asesor');
    }
    
    public function mapa02()
    {
        return view('mapa02.mapa02_asesor'); // ini view khusus halaman setelah simpan
    }
}
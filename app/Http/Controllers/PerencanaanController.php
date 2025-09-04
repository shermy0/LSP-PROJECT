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
            ->with('success', 'Data berhasil');
    }

    public function simpanLanjut(Request $request)
    {
        return redirect()->route('ninjau_asesmen_asesor')
            ->with('success', 'Data berhasil');
    }

    public function simpanLanjutLaporan(Request $request)
    {
        return redirect()->route('laporan_asesor')
            ->with('success', 'Data berhasil');
    }
    
    public function simpanLanjutmapa02(Request $request)
    {
        return redirect()->route('mapa02_asesor.show')
            ->with('success', 'Data berhasil');
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
        return view('mapa02.mapa02_asesor'); 
    }

    public function frVa($periode)
    {
        $validPeriode = [
            'sebelum' => 'Sebelum Asesmen',
            'saat'    => 'Pada Saat Asesmen',
            'sesudah' => 'Setelah Asesmen',
        ];

        if (!array_key_exists($periode, $validPeriode)) {
            abort(404);
        }

        $periodeText = $validPeriode[$periode];

        // kirim periode juga supaya bisa dipakai di form hidden & breadcrumb
        return view('fr_va.fr_va', compact('periode', 'periodeText'));
    }

    // halaman FR VA Asesor
    public function frVaAsesor(Request $request)
    {
        // Ambil periode dari query string atau session agar tahu asalnya
        $periode = $request->query('periode', 'sebelum'); // default 'sebelum' kalau tidak ada

        return view('fr_va.fr_va_asesor', compact('periode'));
    }

    // simpan data FR VA → redirect ke FR VA Asesor
    public function simpanLanjutfrVa(Request $request)
    {
        $periode = $request->periode;

        // proses simpan data di DB

        // redirect ke FR VA Asesor, bawa parameter periode supaya bisa balik
        return redirect()->route('fr_va_asesor', ['periode' => $periode])
                        ->with('success', 'Data berhasil disimpan!');
    }

}
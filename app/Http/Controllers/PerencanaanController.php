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

    public function frak03(Request $request)
    {
        return redirect()->route('frak3.show')
            ->with('success', 'FR.AK.03 berhasil disimpan!');
        }
    public function simpanFrak3(Request $request)
    {
        // logika simpan ke database
        return redirect()->route('frak3')->with('success', 'FR.AK.03 berhasil disimpan!');
    }
    public function getAsesor($skema_id)
    {
        $asesors = DB::table('asesor_skema')
            ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        return response()->json($asesors);
    }

}
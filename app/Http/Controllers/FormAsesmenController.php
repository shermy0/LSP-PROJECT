<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\PembuatanPertanyaan;

class FormAsesmenController extends Controller
{
    public function index()
    {
        // ambil data dari DB
        $skema = Skema::orderBy('nama_skema', 'asc')->get();
        return view('formasesmen', compact('skema'));
    }

    public function pertanyaanEsai($id_skema)
    {
        // cari skema berdasarkan ID
        $skema = Skema::findOrFail($id_skema);
        return view('essai', compact('skema'));
    }

    // ================== VIEW PER SKEMA ==================
    public function officeadministative()
    {
        return view('officeadministative'); 
    }

    public function pemogramanjunior()
    {
        return view('pemogramanjunior'); 
    }

    public function juniortechnicalsupport()
    {
        return view('juniortechnicalsupport'); 
    }

    public function junioroperatordesigngrafis()
    {
        return view('junioroperatordesigngrafis'); 
    }

    public function akuntansikeuanganII()
    {
        return view('akuntansikeuanganII'); 
    }

    // ================== SHOW SKEMA DINAMIS ==================
    public function showSkema($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $viewMap = [
            'Junior Operator Desain Grafis' => 'junioroperatordesigngrafis',
            'Junior Technical Support' => 'juniortechnicalsupport',
            'Pemrogram Junior (Junior Coder)' => 'pemogramanjunior',
            'Office Administrative' => 'officeadministative',
            'Pramuniaga' => 'pramuniaga',
            'Akuntansi dan Keuangan Lembaga 2' => 'akuntansikeuanganII',
        ];

        if (array_key_exists($skema->nama_skema, $viewMap)) {
            return view($viewMap[$skema->nama_skema], compact('skema'));
        }

        // fallback kalau belum ada blade khusus
        return view('default', compact('skema'));
    }

    // ================== ESAI ==================
    public function createEsai(Request $request)
    {
        $jumlah   = $request->query('jumlah', 5); 
        $id_skema = $request->query('id_skema');

        $skema = Skema::findOrFail($id_skema);

        $pembuatan = PembuatanPertanyaan::create([
            'id_skema' => $id_skema,
            'timer'    => 0, // sementara
            'timescap' => now(),
        ]);

        return view('input_esai', compact('skema', 'jumlah', 'pembuatan'));
    }

    public function showPembuatan($id_pembuatan)
    {
        $pembuatan = PembuatanPertanyaan::with('pertanyaan')->findOrFail($id_pembuatan);
        return view('show_pembuatan', compact('pembuatan')); 
    }
}

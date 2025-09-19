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

public function pertanyaanLisan($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    return view('lisan', compact('skema'));
}

public function showSkema($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    // mapping nama skema ke blade langsung di /views/
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

public function createEsai(Request $request)
{
    $jumlah   = $request->query('jumlah', 5); 
    $id_skema = $request->query('id_skema');

    $skema = Skema::findOrFail($id_skema);

    // Buat pembuatan pertanyaan baru tapi belum ada pertanyaan
    $pembuatan = PembuatanPertanyaan::create([
        'id_skema' => $id_skema,
        'timer'    => 0, // sementara
        'timescap' => now(),
    ]);

    return view('input_esai', compact('skema', 'jumlah', 'pembuatan'));
}

    public function showPembuatan($id_pembuatan)
{
    // Ambil data pembuatan + pertanyaan-pertanyaannya
    $pembuatan = PembuatanPertanyaan::with('pertanyaan')->findOrFail($id_pembuatan);

}


}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

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

}


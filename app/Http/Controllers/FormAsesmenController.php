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

public function pertanyaanPG($id_skema)
{
    // cari skema berdasarkan ID
    $skema = Skema::findOrFail($id_skema);

    return view('pg', compact('skema')); // pastikan view pg.blade.php ada
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
        'Akuntansi dan Keuangan Lembaga 1' => 'akuntansidankeuanganlembaga1',
        'Teknik Komputer dan Jaringan 2' => 'teknikkomputerdanjaringan2',
        'Teknik Komputer dan Jaringan 3' => 'teknikkomputerdanjaringan3',
        'Teknik Komputer dan Jaringan 4' => 'teknikkomputerdanjaringan4',
        
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
public function kelompokPekerjaanPG($id_skema)
{
    $skema = Skema::findOrFail($id_skema);
    
    // Redirect ke controller PertanyaanController untuk menangani kelompok pekerjaan
    return redirect()->route('pertanyaan.pg.kelompok', [
        'id_skema' => $id_skema,
        'jenis' => 'pilihan_ganda'
    ]);
}

public function createPG(Request $request)
{
    $jumlah   = $request->query('jumlah', 5); 
    $id_skema = $request->query('id_skema');

    $skema = Skema::findOrFail($id_skema);

    // Buat record baru di pembuatan_pertanyaan
    $pembuatan = PembuatanPertanyaan::create([
        'id_skema' => $id_skema,
        'timer'    => 0, // default, nanti bisa diatur user
        'timescap' => now(),
    ]);

    return view('input_pg', compact('skema', 'jumlah', 'pembuatan'));
}



}


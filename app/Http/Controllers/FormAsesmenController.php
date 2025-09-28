<?php

namespace App\Http\Controllers;

use App\Models\KelompokPekerjaan;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\PembuatanPertanyaan;
use App\Models\Pertanyaan;

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
    $skema = Skema::findOrFail($id_skema);

    // ambil semua pembuatan pertanyaan untuk skema ini
    $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
                        ->orderBy('id_pembuatan_pertanyaan', 'desc')
                        ->get();

    return view('essai', compact('skema', 'pembuatanList'));
}


public function pertanyaanLisan($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    // Ambil semua pembuatan pertanyaan untuk skema ini
    $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
                                        ->where('jenis_pertanyaan', 'lisan') // sesuai jenis pertanyaan
                                        ->get();

    return view('lisan', compact('skema', 'pembuatanList'));
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
    $id_skema = $request->query('id_skema');
    $id_pembuatan = $request->query('id_pembuatan'); 
    $jumlah = $request->query('jumlah', 5);

    $skema = Skema::findOrFail($id_skema);

    if ($id_pembuatan) {
        $pembuatan = PembuatanPertanyaan::with('pertanyaan')->findOrFail($id_pembuatan);
    } else {
        $pembuatan = PembuatanPertanyaan::create([
            'id_skema' => $id_skema,
            'timer'    => 0,
        ]);
    }

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


public function listPembuatan($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    // Ambil semua pembuatan pertanyaan untuk skema ini
    $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
                        ->orderBy('created_at', 'desc')
                        ->get();

    return view('esai_list_pembuatan', compact('skema', 'pembuatanList'));
}

// FormAsesmenController.php
public function pertanyaanPMO($id_skema)
{
    $skema = \App\Models\Skema::findOrFail($id_skema);

    // kalau butuh tambahan data
    $kelompok = \App\Models\KelompokPekerjaan::where('id_skema', $id_skema)->first();
    $pembuatanList = \App\Models\PembuatanPertanyaan::where('id_skema', $id_skema)->get();

    return view('PMO', compact('skema', 'kelompok', 'pembuatanList'));
}
 public function jawabanPMO($id_skema)
    {
        // Ambil data skema
        $skema = Skema::findOrFail($id_skema);

        // Ambil semua kelompok beserta unit kompetensi
        $kelompok = KelompokPekerjaan::with('unitKompetensi')
                            ->where('id_skema', $id_skema)
                            ->get();

        // Ambil pembuatan pertanyaan PMO untuk skema ini
        $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
                                            ->where('jenis_pertanyaan', 'pmo')
                                            ->get();

        // Ambil timer dari pembuatan pertama (default 30 menit)
        $timer = $pembuatanList->first()->timer ?? 30;

        return view('jawaban_kelompok_PMO', compact('skema', 'kelompok', 'pembuatanList', 'timer'));
    }
public function tampilJawabanPMO($id_skema, $id_pembuatan)
{
    $skema = Skema::findOrFail($id_skema);

    $pembuatan = PembuatanPertanyaan::findOrFail($id_pembuatan);

    $kelompok = KelompokPekerjaan::with('unitKompetensi')
                    ->where('id_skema', $id_skema)
                    ->get();

    $pertanyaan = Pertanyaan::where('id_pembuatan_pertanyaan', $id_pembuatan)->get();

    $timer = $pembuatan->timer ?? 30;

    return view('jawaban_PMO', compact('skema', 'kelompok', 'pertanyaan', 'pembuatan', 'timer'));
}
// app/Http/Controllers/FormAsesmenController.php

public function tampilPMO(Request $request, $id_skema)
{
    // Ambil data skema
    $skema = Skema::findOrFail($id_skema);

    // Ambil semua pembuatan pertanyaan PMO untuk skema ini
    $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
                                        ->where('jenis_pertanyaan', 'pmo')
                                        ->get();

    // Kalau ada pembuatan pertama, redirect langsung ke halaman jawaban
    if ($pembuatanList->isNotEmpty()) {
        $pembuatan = $pembuatanList->first();
        return redirect()->route('jawaban_pmo.form', [
            'id_skema' => $id_skema,
            'id_pembuatan' => $pembuatan->id_pembuatan_pertanyaan
        ]);
    }

    // Kalau belum ada, tampilkan pesan / halaman kosong
    return back()->with('warning', 'Belum ada pembuatan PMO untuk skema ini.');
}

}


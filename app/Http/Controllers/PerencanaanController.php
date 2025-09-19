<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\InstrumenAsesmen;
use App\Models\LaporanAsesmen;

class PerencanaanController extends Controller
{
    // Form Perencanaan
    public function index()
    {
        return view('formperencanaan'); 
    }

    public function simpan(Request $request)
    {
        return redirect()->route('formperencanaan')
            ->with('success', 'Data berhasil');
    }

    // Meninjau Asesmen 
    public function simpanLanjut(Request $request)
    {
        return redirect()->route('ninjau_asesmen_asesor')
            ->with('success', 'Data berhasil');
    }

    public function ninjauAsesmenAsesor() 
    {
        return view('ninjau_asesmen_asesor');
    }

    public function show($id)
    {
        // coba cari record mapa02: coba cocokkan id_mapa02 dulu, kalau nggak ada coba cocokkan id_asesmen
        $mapa02 = DB::table('mapa02')
                    ->where('id_mapa02', $id)
                    ->orWhere('id_asesmen', $id)
                    ->first();
    
        // ambil skema_id dengan aman
        $currentSkemaId = $mapa02->skema_id ?? null;
    
        // semua skema untuk dropdown
        $skemas = Skema::all();
    
        // objek skema terpilih (opsional, kalau butuh menampilkan nama/kode langsung)
        $skema = $currentSkemaId ? Skema::find($currentSkemaId) : null;
    
        return view('ninjau_asesmen', compact('skemas', 'currentSkemaId', 'skema'));
    }

    // Laporan
    public function simpanLanjutLaporan(Request $request)
    {
        $asesor = Asesor::find($request->asesor_id);
    
        if (!$asesor) {
            return redirect()->route('laporan')->with('error', 'Asesor tidak ditemukan.');
        }
    
        return view('laporan_asesor', [
            'asesor' => $asesor,
            'no_registrasi' => $request->no_registrasi,
            'skema_id' => $request->skema_id
        ]);
    }

    public function laporan(Request $request)
    {
        $asesorId = $request->input('asesor_id');
        $no_registrasi = $request->input('no_registrasi');

        $asesor = \App\Models\Asesor::find($asesorId);

        if (!$asesor) {
            return redirect()->route('laporan')->with('error', 'Asesor tidak ditemukan.');
        }

        return view('laporan_asesor', [
            'asesor' => $asesor,
            'no_registrasi' => $no_registrasi
        ]);
    }

    // MAPA 02
    public function mapa02(Request $request)
    {
        $skemaId = $request->skema_id; 
        $skema   = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
        $instrumen = InstrumenAsesmen::all();

        if ($skemaId) {
            $instrumen = DB::table('skema_instrumen')
                ->join('instrumen_asesmen', 'skema_instrumen.instrumen_id', '=', 'instrumen_asesmen.id_instrumen')
                ->where('skema_instrumen.skema_id', $skemaId)
                ->select('instrumen_asesmen.*')
                ->get();
        }

        $skemas = DB::table('skema_sertifikasi')->get(); // tambahkan ini

        return view('mapa02_asesor', [
            'skemaId'   => $skemaId,
            'skema'     => $skema,
            'instrumen' => $instrumen,
            'skemas'    => $skemas // kirim juga ke view
        ]);
    }
    public function simpanMapa02(Request $request)
    {
        // validasi sederhana
        $request->validate([
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
        ]);
    
        // update atau insert ke tabel mapa02
        DB::table('mapa02')->updateOrInsert(
            ['id_mapa02' => $request->id_mapa02], // kalau sudah ada update
            ['skema_id' => $request->skema_id]
        );
    
        return redirect()->route('ninjau_asesmen', ['id' => $request->id_mapa02])
            ->with('success', 'Skema berhasil disimpan ke MAPA02');
    }
    
    public function simpanLanjutmapa02(Request $request)
    {
        return redirect()->route('mapa02_asesor.show')
            ->with('success', 'Data berhasil');
    }

    public function showForm($id_skema)
    {
        // Ambil skema
        $skema = DB::table('skema_sertifikasi')
            ->where('id_skema', $id_skema)
            ->first();

        // Cari asesor sesuai bidang keahlian skema
        $asesor = DB::table('asesor')
            ->where('bidang_keahlian', $skema->bidang_keahlian)
            ->first();

        return view('nama_view', [
            'skema' => $skema,
            'asesor' => $asesor,
            'no_registrasi' => $asesor->no_registrasi ?? null,
        ]);
    }

    // FR VA
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

        return view('fr_va', compact('periode', 'periodeText'));
    }

    public function frVaAsesor(Request $request)
    {
        $periode = $request->query('periode', 'sebelum'); 
        
        return view('fr_va_asesor', compact('periode'));
    }

    public function simpanLanjutfrVa(Request $request)
    {
        $periode = $request->periode;

        return redirect()->route('fr_va_asesor', ['periode' => $periode])
                        ->with('success', 'Data berhasil disimpan!');
    }

    public function store(Request $request)
    {
        LaporanAsesmen::create([
            'id_instrumen' => $request->skema_id,
            'aspek_positif_negatif' => $request->aspek_positif_negatif,
            'penolakan' => $request->penolakan,
            'saran_perbaikan' => $request->saran_perbaikan,
            'tgl_laporan' => now()->toDateString(),
        ]);

        return redirect()->route('laporan_asesor.index')
            ->with('success', 'Laporan asesmen berhasil disimpan.');
    }
}
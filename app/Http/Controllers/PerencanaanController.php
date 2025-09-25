<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstrumenAsesmen;
use App\Models\LaporanAsesmen;
use App\Models\Skema;
use App\Models\Asesor;
use Carbon\Carbon;

class PerencanaanController extends Controller
{
    // 1️⃣ Form Perencanaan
    public function index()
    {
        $skemas = Skema::all();
        return view('formperencanaan', compact('skemas'));
    }

    public function simpan(Request $request)
    {
        return redirect()->route('formperencanaan')
            ->with('success', 'Data berhasil disimpan');
    }

    // 2️⃣ Meninjau Asesmen
    public function ninjauAsesmenAsesor()
    {
        return view('ninjau_asesmen_asesor');
    }

    public function show($id)
    {
        $mapa02 = DB::table('mapa02')
                    ->where('id_mapa02', $id)
                    ->orWhere('id_asesmen', $id)
                    ->first();

        $currentSkemaId = $mapa02->skema_id ?? null;
        $skemas = Skema::all();
        $skema = $currentSkemaId ? Skema::find($currentSkemaId) : null;

        return view('ninjau_asesmen', compact('skemas', 'currentSkemaId', 'skema'));
    }

    public function simpanLanjutLaporan(Request $request)
    {
        $request->validate([
            'aspek_positif_negatif' => 'nullable|string',
            'penolakan' => 'nullable|string',
            'saran_perbaikan' => 'nullable|string',
            'asesor_id' => 'required',
            'skema_id' => 'required',
            'no_registrasi' => 'required',
        ]);

        LaporanAsesmen::create([
            'aspek_positif_negatif' => $request->aspek_positif_negatif,
            'penolakan' => $request->penolakan,
            'saran_perbaikan' => $request->saran_perbaikan,
            'tgl_laporan' => now()->toDateString(),
            'asesor_id' => $request->asesor_id,
            'skema_id' => $request->skema_id,
            'no_registrasi' => $request->no_registrasi,
        ]);

        return redirect()->route('laporan_asesor.index')
        ->with('success', 'Catatan asesmen berhasil disimpan!');    
    }

    public function laporan()
{
    // Ambil semua laporan beserta relasi asesor & skema
    $laporans = LaporanAsesmen::with(['asesor', 'skema'])->get();

    return view('laporan_asesor', compact('laporans'));
}

    // 5️⃣ MAPA02
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

        $skemas = DB::table('skema_sertifikasi')->get();

        return view('mapa02_asesor', compact('skemaId','skema','instrumen','skemas'));
    }

    public function simpanMapa02(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
        ]);

        DB::table('mapa02')->updateOrInsert(
            ['id_mapa02' => $request->id_mapa02],
            ['skema_id' => $request->skema_id]
        );

        return redirect()->route('ninjau_asesmen', ['id'=>$request->id_mapa02])
            ->with('success', 'Skema berhasil disimpan ke MAPA02');
    }

    // 6️⃣ FR VA
    public function frVa($periode)
    {
        $validPeriode = ['sebelum'=>'Sebelum Asesmen','saat'=>'Pada Saat Asesmen','sesudah'=>'Setelah Asesmen'];
        if(!array_key_exists($periode,$validPeriode)) abort(404);

        $periodeText = $validPeriode[$periode];
        return view('fr_va', compact('periode','periodeText'));
    }

    public function frVaAsesor(Request $request)
    {
        $periode = $request->query('periode','sebelum'); 
        return view('fr_va_asesor', compact('periode'));
    }

    public function simpanLanjutfrVa(Request $request)
    {
        return redirect()->route('fr_va_asesor', ['periode'=>$request->periode])
                        ->with('success','Data berhasil disimpan!');
    }

    // 7️⃣ Simpan laporan asesmen
    public function store(Request $request)
    {
        LaporanAsesmen::create([
            'id_instrumen' => $request->skema_id,
            'aspek_positif_negatif' => $request->aspek_positif_negatif,
            'penolakan' => $request->penolakan,
            'saran_perbaikan' => $request->saran_perbaikan,
            'tgl_laporan' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('laporan_asesor')
            ->with('success','Laporan asesmen berhasil disimpan.');
    }

    // 8️⃣ AJAX: ambil asesor sesuai skema
    public function getAsesor($skemaId)
    {
        $asesor = Asesor::where('skema_id',$skemaId)->get();
        return response()->json($asesor);
    }

    // 9️⃣ AJAX: ambil asesi sesuai skema & asesor
    public function getAsesi($skemaId,$asesorId)
    {
        $asesi = DB::table('asesi')
                    ->where('skema_id',$skemaId)
                    ->where('asesor_id',$asesorId)
                    ->get();
        return response()->json($asesi);
    }
}

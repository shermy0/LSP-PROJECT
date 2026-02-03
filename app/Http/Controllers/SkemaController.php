<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use App\Models\MeninjauAsesmen;
use App\Models\PenyusunPersetujuan;
use App\Models\InstrumenAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SkemaController extends Controller
{
    public function getUnitsFromMapa01($skema_id)
{
    $kelompokPekerjaan = \App\Models\KelompokPekerjaan::with([
        'hasilAsesmen.unit'
    ])->where('id_skema', $skema_id)->get();

    return view('mapa02', compact('kelompokPekerjaan'));
}

        // Meninjau Asesmen yang Menampilkan semua skema
    public function ninjau_asesemen() 
    {
        $skemas = Skema::all();
        return view('ninjau_asesemen', compact('skemas'));
    }
    
    public function formMapa01()
{
    $skemas = Skema::all();
    return view('form_perencanaan.form_mapa_01.mapa01', compact('skemas'));
}

    public function laporan(Request $request)
    {
        $skemas = Skema::with('units')->get();

        $selectedSkema = $request->input('skema_id');
        $asesors = collect();

        if ($selectedSkema) {
            $skema = DB::table('skema_sertifikasi')->where('id', $selectedSkema)->first();

            if ($skema) {
                $asesors = DB::table('asesor')
                    ->where('bidang_keahlian', $skema->bidang_keahlian)
                    ->select('id_asesor', 'nama_asesor')
                    ->get();
            }
        }

        return view('laporan', compact('skemas', 'asesors', 'selectedSkema'));
    }
    
    // Relasi Skema ke Unit Kompetensi
    public function units()
    {
        return $this->hasMany(UnitKompetensi::class, 'skema_id', 'id_skema');
    }

    // Halaman MAPA 02 yang Menampilkan semua skema
    public function mapa02()
    {
        $skemas = Skema::all(); 
        return view('mapa02', compact('skemas'));
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
    public function store(Request $request)
    {
        MeninjauAsesmen::create([
            'id_asesmen' => $request->id_asesmen ?? 1,
            'asesor_id' => $request->asesor_id,

            // Rencana Asesmen
            'rencana_valid' => $request->has('rencana_valid'),
            'rencana_reliabel' => $request->has('rencana_reliabel'),
            'rencana_fleksibel' => $request->has('rencana_fleksibel'),
            'rencana_adil' => $request->has('rencana_adil'),

            // Persiapan
            'persiapan_valid' => $request->has('persiapan_valid'),
            'persiapan_reliabel' => $request->has('persiapan_reliabel'),
            'persiapan_fleksibel' => $request->has('persiapan_fleksibel'),
            'persiapan_adil' => $request->has('persiapan_adil'),

            // Implementasi
            'implementasi_valid' => $request->has('implementasi_valid'),
            'implementasi_reliabel' => $request->has('implementasi_reliabel'),
            'implementasi_fleksibel' => $request->has('implementasi_fleksibel'),
            'implementasi_adil' => $request->has('implementasi_adil'),

            // Keputusan
            'keputusan_valid' => $request->has('keputusan_valid'),
            'keputusan_reliabel' => $request->has('keputusan_reliabel'),
            'keputusan_fleksibel' => $request->has('keputusan_fleksibel'),
            'keputusan_adil' => $request->has('keputusan_adil'),

            // Umpan balik
            'umpan_valid' => $request->has('umpan_valid'),
            'umpan_reliabel' => $request->has('umpan_reliabel'),
            'umpan_fleksibel' => $request->has('umpan_fleksibel'),
            'umpan_adil' => $request->has('umpan_adil'),

            // Rekomendasi 1
            'rekomendasi1' => $request->rekomendasi1,

            // Konsistensi
            'konsistensi_task' => $request->konsistensi_task,
            'konsistensi_task_mgmt' => $request->konsistensi_task_mgmt,
            'konsistensi_contingency' => $request->konsistensi_contingency,
            'konsistensi_jobrole' => $request->konsistensi_jobrole,
            'konsistensi_transfer' => $request->konsistensi_transfer,

            // Bukti
            'bukti_task' => $request->bukti_task,
            'bukti_task_mgmt' => $request->bukti_task_mgmt,
            'bukti_contingency' => $request->bukti_contingency,
            'bukti_jobrole' => $request->bukti_jobrole,
            'bukti_transfer' => $request->bukti_transfer,

            // Rekomendasi 2
            'rekomendasi2' => $request->rekomendasi2,
        ]);
        return redirect()
        ->route('ninjau_asesmen_asesor.view', ['asesor_id' => $request->asesor_id])
        ->with('success', 'Data berhasil disimpan!');
    }
    public function simpanPersetujuan(Request $request, $asesor_id)
    {
        // Handle tanda tangan
        if ($request->has('tanda_tangan')) {
            $ttd = $request->tanda_tangan;
            $ttd = str_replace('data:image/png;base64,', '', $ttd);
            $ttd = str_replace(' ', '+', $ttd);
            $ttdName = 'ttd_' . $asesor_id . '_' . time() . '.png';
            File::put(storage_path('app/public/ttd/') . $ttdName, base64_decode($ttd));

            $tanda_tangan = 'ttd/' . $ttdName;
        } else {
            $tanda_tangan = null;
        }

        // Simpan ke DB
        PenyusunPersetujuan::create([
            'asesor_id'       => $asesor_id,
            'tanggal_asesmen' => $request->tanggal_asesmen,
            'tanda_tangan'    => $tanda_tangan,
            'komentar'        => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Persetujuan berhasil disimpan!');
    }
    
    public function show($id)
    {
        // ambil data dari mapa02
        $mapa02 = DB::table('mapa02')->where('id_mapa02', $id)->first();
    
        // kalau ada skema_id, ambil skema dari model Skema
        $currentSkemaId = $mapa02->skema_id ?? null;
    
        return view('ninjau_asesmen', [
            'skemas'         => Skema::all(),
            'currentSkemaId' => $currentSkemaId,
            'skema'          => $currentSkemaId ? Skema::find($currentSkemaId) : null,
        ]);
    }

public function showForm()
{
    $skemas = Skema::with('units')->get();
    $instrumen = InstrumenAsesmen::all();
    $kelompokPekerjaan = collect(); // biar ga error Undefined variable

    return view('mapa02', compact('skemas', 'instrumen', 'kelompokPekerjaan'));
}

    // Ambil data Asesor berdasarkan skema
    // Ambil data Asesi berdasarkan skema dan asesor
    public function getAsesi($skemaId, $asesorId)
    {
        $asesi = DB::table('asesi')
            ->where('asesor_id', $asesorId)
            ->select('id_asesi', 'nama_lengkap')
            ->get();

        return response()->json($asesi);
    }

    public function simpanInstrumen(Request $request)
    {
        $skemaId = $request->skema_id;
        $asesorId = auth()->user()->asesor->id_asesor; // asumsi relasi user → asesor

        foreach ($request->potensi as $instrumenId => $value) {
            DB::table('asesmen_instrumen_jawaban')->insert([
                'skema_id' => $skemaId,
                'instrumen_id' => $instrumenId,
                'asesor_id' => $asesorId,
                'potensi' => $value,
            ]);
        }

        return back()->with('success', 'Instrumen berhasil disimpan');
    }

    public function getUnits($skemaId) {
        $units = UnitKompetensi::where('skema_id', $skemaId)->get();
        return response()->json($units);
    }    
    


}
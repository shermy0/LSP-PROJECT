<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Models\MeninjauAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeninjauAsesmenController extends Controller
{
    // Halaman awal meninjau asesmen (pilih skema)
public function showNinjauAsesmen($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    $asesors = DB::table('asesor_skema')
        ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
        ->where('asesor_skema.skema_id', $id_skema)
        ->select('asesor.id_asesor', 'asesor.nama_asesor')
        ->get();

    return view('form_perencanaan.meninjau_asesmen.ninjau_asesmen', compact('skema', 'asesors'));
}

    // Halaman per skema (tampilkan daftar asesor di skema tersebut)
public function ninjauAsesmenAsesor($id_skema)
{
    $skema = Skema::findOrFail($id_skema);
    $asesors = DB::table('asesor_skema')
        ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
        ->where('asesor_skema.skema_id', $id_skema)
        ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi')
        ->get();
    $asesor_terpilih = $asesors->first()->id_asesor ?? null;
    $no_registrasi_terpilih = $asesors->first()->no_registrasi ?? null;
    return view('form_perencanaan.meninjau_asesmen.ninjau_asesmen_asesor', compact('skema', 'asesors', 'asesor_terpilih', 'no_registrasi_terpilih'));
}
    // Ambil asesor berdasarkan skema (AJAX)
    public function getAsesor($skema_id)
    {
        $asesors = DB::table('asesor_skema')
            ->join('asesor', 'asesor_skema.asesor_id', '=', 'asesor.id_asesor')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.id_asesor', 'asesor.nama_asesor')
            ->get();

        return response()->json($asesors);
    }

    // Simpan hasil review asesmen
    public function store(Request $request, $id_skema)
    {
        // Ubah array ke string (pisahkan pakai koma)
        $konsistensi_task = implode(',', $request->input('konsistensi_task', []));
        $konsistensi_task_mgmt = implode(',', $request->input('konsistensi_task_mgmt', []));
        $konsistensi_contingency = implode(',', $request->input('konsistensi_contingency', []));
        $konsistensi_jobrole = implode(',', $request->input('konsistensi_jobrole', []));
        $konsistensi_transfer = implode(',', $request->input('konsistensi_transfer', []));

        $bukti_task = implode(',', $request->input('bukti_task', []));
        $bukti_task_mgmt = implode(',', $request->input('bukti_task_mgmt', []));
        $bukti_contingency = implode(',', $request->input('bukti_contingency', []));
        $bukti_jobrole = implode(',', $request->input('bukti_jobrole', []));
        $bukti_transfer = implode(',', $request->input('bukti_transfer', []));

        MeninjauAsesmen::create([
            'skema_id' => $request->skema_id,  
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

            // Konsistensi (sudah di-implode)
            'konsistensi_task' => $konsistensi_task,
            'konsistensi_task_mgmt' => $konsistensi_task_mgmt,
            'konsistensi_contingency' => $konsistensi_contingency,
            'konsistensi_jobrole' => $konsistensi_jobrole,
            'konsistensi_transfer' => $konsistensi_transfer,

            // Bukti (sudah di-implode)
            'bukti_task' => $bukti_task,
            'bukti_task_mgmt' => $bukti_task_mgmt,
            'bukti_contingency' => $bukti_contingency,
            'bukti_jobrole' => $bukti_jobrole,
            'bukti_transfer' => $bukti_transfer,

            // Rekomendasi 2
            'rekomendasi2' => $request->rekomendasi2,
        ]);

        return redirect()->route('form_perencanaan.ninjau_asesmen_asesor', ['id_skema' => $id_skema])
        ->with('success', 'Data berhasil disimpan!');

    }


    // Simpan lalu langsung lanjut ke halaman asesor
    public function simpanLanjut(Request $request, $id_skema)
    {
        return redirect()
            ->route('form_perencanaan.ninjau_asesmen_asesor', ['id_skema' => $id_skema])
            ->with('success', 'Data berhasil disimpan dan dilanjutkan!');
    }

    // Kalau ada simpan persetujuan
    public function simpanPersetujuan(Request $request, $asesor_id)
    {
        // logika simpan persetujuan di sini
        return redirect()
            ->route('form_perencanaan.ninjau_asesmen_asesor.simpan', ['asesor_id' => $asesor_id])
            ->with('success', 'Persetujuan berhasil disimpan!');
    }
}
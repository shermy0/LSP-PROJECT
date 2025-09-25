<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use App\Models\MeninjauAsesmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SkemaController extends Controller
{
    public function ninjau_asesemen()
    {
        $skemas = Skema::all(); 
        return view('meninjau_asesmen/ninjau_asesemen', compact('skemas'));
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

        return redirect()->route('ninjau_asesmen_asesor.view')
            ->with('success', 'Data berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers\FormPerencanaan;

use Illuminate\Support\Facades\DB;  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;


class ModifikasiController extends Controller
{
public function index($skema_id)
{
    $skema = Skema::findOrFail($skema_id);

    // Ambil data persyaratan modifikasi untuk skema ini
    $modifikasi = DB::table('persyaratan_modifikasi')
                    ->where('skema_id', $skema_id)
                    ->first();

    return view(
        'form_perencanaan.form_mapa_01.mapa01_modifikasi',
        compact('skema', 'modifikasi')
    );
}


public function store(Request $request, $skema_id)
{
    $validated = $request->validate([
        'karakteristik_kandidat' => 'nullable|in:Tidak Ada,Ada',
        'karakteristik_text' => 'nullable|string',
        
        'kebutuhan_kontekstual' => 'nullable|in:Tidak Ada,Ada',
        'kontekstual_text' => 'nullable|string',
        
        'saran_pelatihan' => 'nullable|in:Tidak Ada,Ada',
        'saran_text' => 'nullable|string',
        
        'penyesuaian_asesmen' => 'nullable|in:Tidak Ada,Ada',
        'penyesuaian_text' => 'nullable|string',
        
        'peluang_asesmen' => 'nullable|in:Tidak Ada,Ada',
        'peluang_text' => 'nullable|string',
    ]);

    DB::table('persyaratan_modifikasi')->updateOrInsert(
        ['skema_id' => $skema_id], 
        [
            'karakteristik_kandidat'   => $validated['karakteristik_kandidat'] ?? null,
            'karakteristik_keterangan' => $validated['karakteristik_text'] ?? null,

            'kebutuhan_tempat_kerja'   => $validated['kebutuhan_kontekstual'] ?? null,
            'kebutuhan_keterangan'     => $validated['kontekstual_text'] ?? null,

            'saran_pelatihan'          => $validated['saran_pelatihan'] ?? null,
            'saran_keterangan'         => $validated['saran_text'] ?? null,

            'penyesuaian_asesmen'      => $validated['penyesuaian_asesmen'] ?? null,
            'penyesuaian_keterangan'   => $validated['penyesuaian_text'] ?? null,

            'peluang_asesmen'          => $validated['peluang_asesmen'] ?? null,
            'peluang_keterangan'       => $validated['peluang_text'] ?? null,

            'updated_at' => now()
        ]
    );

    return redirect()->route('form.mapa01.konfirmasi', ['skema_id' => $skema_id])
                     ->with('success', 'Data persyaratan modifikasi berhasil disimpan.');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\UmpanBalik;
use Illuminate\Http\Request;

class UmpanBalikController extends Controller
{
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_skema' => 'nullable|integer',
            'id_asesor' => 'nullable|integer',
            'id_asesi' => 'nullable|integer',
            'nomor_skema' => 'nullable|string',
            'tempat' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'penjelasan_proses' => 'nullable|boolean',
            'catatan_proses' => 'nullable|string',
            'kesempatan_mempelajari' => 'nullable|boolean',
            'catatan_mempelajari' => 'nullable|string',
            'diskusi_metoda' => 'nullable|boolean',
            'catatan_diskusi' => 'nullable|string',
            'menggali_bukti' => 'nullable|boolean',
            'catatan_bukti' => 'nullable|string',
            'demonstrasi_kompetensi' => 'nullable|boolean',
            'catatan_demonstrasi' => 'nullable|string',
            'penjelasan_keputusan' => 'nullable|boolean',
            'catatan_keputusan' => 'nullable|string',
            'umpan_balik' => 'nullable|boolean',
            'catatan_umpan_balik' => 'nullable|string',
            'mempelajari_dokumen' => 'nullable|boolean',
            'catatan_dokumen' => 'nullable|string',
            'jaminan_rahasia' => 'nullable|boolean',
            'catatan_rahasia' => 'nullable|string',
            'komunikasi_efektif' => 'nullable|boolean',
            'catatan_komunikasi' => 'nullable|string',
            'catatan_lainnya' => 'nullable|string',
        ]);

        UmpanBalik::create($data);

        return redirect()->back()->with('success', 'Umpan balik berhasil disimpan!');
    }
}

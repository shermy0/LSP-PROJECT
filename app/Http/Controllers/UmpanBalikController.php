<?php

namespace App\Http\Controllers;

use App\Models\UmpanBalik;
use Illuminate\Http\Request;

class UmpanBalikController extends Controller
{
    /**
     * Simpan data umpan balik ke database
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'id_skema' => 'nullable|integer',
            'id_asesor' => 'nullable|integer',
            'id_asesi' => 'nullable|integer',
            'nomor_skema' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',

            // Proses Asesmen
            'penjelasan_proses' => 'nullable|boolean',
            'catatan_proses' => 'nullable|string|max:500',

            // Mempelajari materi
            'kesempatan_mempelajari' => 'nullable|boolean',
            'catatan_mempelajari' => 'nullable|string|max:500',

            // Diskusi metoda
            'diskusi_metoda' => 'nullable|boolean',
            'catatan_diskusi' => 'nullable|string|max:500',

            // Bukti kompetensi
            'menggali_bukti' => 'nullable|boolean',
            'catatan_bukti' => 'nullable|string|max:500',

            // Demonstrasi
            'demonstrasi_kompetensi' => 'nullable|boolean',
            'catatan_demonstrasi' => 'nullable|string|max:500',

            // Keputusan
            'penjelasan_keputusan' => 'nullable|boolean',
            'catatan_keputusan' => 'nullable|string|max:500',

            // Umpan balik
            'umpan_balik' => 'nullable|boolean',
            'catatan_umpan_balik' => 'nullable|string|max:500',

            // Dokumen
            'mempelajari_dokumen' => 'nullable|boolean',
            'catatan_dokumen' => 'nullable|string|max:500',

            // Jaminan kerahasiaan
            'jaminan_rahasia' => 'nullable|boolean',
            'catatan_rahasia' => 'nullable|string|max:500',

            // Komunikasi
            'komunikasi_efektif' => 'nullable|boolean',
            'catatan_komunikasi' => 'nullable|string|max:500',

            // Catatan tambahan
            'catatan_lainnya' => 'nullable|string|max:1000',
        ]);

        // Simpan ke database
        UmpanBalik::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()
            ->back()
            ->with('success', 'Umpan balik berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesi;
use App\Models\SkemaSertifikasi;
use App\Models\KelompokPekerjaan;
use App\Models\Kuk;
use App\Models\ObservasiCeklis;
use App\Models\ObservasiCeklisItem;
use App\Models\ObservasiCeklisPersetujuan;

class CeklisObservasiController extends Controller
{
    /**
     * Halaman utama form ceklis observasi
     */
    public function index()
    {
        $asesi = Asesi::all();
        $skema = SkemaSertifikasi::all();

        return view('ceklis_observasi', compact('asesi', 'skema'));
    }

    /**
     * Load data dinamis (KUK dan kelompok kerja berdasarkan skema)
     */
    public function loadData($skemaId)
    {
        $skema = SkemaSertifikasi::find($skemaId);
        $kelompok = KelompokPekerjaan::with(['unitKompetensi.elemen.kuk'])
            ->where('id_skema', $skemaId)
            ->get();

        return response()->json([
            'skema_nama' => $skema?->nama_skema,
            'kelompok'   => $kelompok,
        ]);
    }

    /**
     * Simpan hasil observasi ke database
     */
public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'id_asesi'     => 'required|exists:asesi,id_asesi',
            'id_skema'     => 'required|exists:skema_sertifikasi,id_skema',
            'kuk'          => 'required|array',
            'ttd_asesor'   => 'required',
            'umpan_balik'  => 'nullable|string',
            'rekomendasi'  => 'nullable|string|in:Kompeten,Belum Kompeten',
            'rekomendasi_rincian' => 'nullable|string',
        ]);

        $idAsesor = auth()->user()->asesor->id_asesor ?? null;
        if (!$idAsesor) {
            return back()->with('error', 'Asesor tidak ditemukan.');
        }

        // simpan observasi utama
        $observasi = ObservasiCeklis::create([
            'id_skema' => $validated['id_skema'],
            'id_asesor' => $idAsesor,
            'id_asesi' => $validated['id_asesi'],
            'umpan_balik' => $validated['umpan_balik'] ?? null,
            'rekomendasi' => $validated['rekomendasi'] ?? null,
            'rekomendasi_rincian' => $validated['rekomendasi_rincian'] ?? null,
        ]);

        // simpan item observasi
        foreach ($validated['kuk'] as $kukId => $row) {
            $kukModel = Kuk::with('elemen.unit')->findOrFail($kukId);

            ObservasiCeklisItem::create([
                'id_observasi' => $observasi->id_observasi,
                'id_skema' => $validated['id_skema'],
                'id_unit' => $kukModel->elemen->id_unit,
                'id_elemen' => $kukModel->id_elemen,
                'id_kuk' => $kukModel->id_kuk,
                'standar_industri' => $row['standar_industri'] ?? 'Modul Praktek',
                'pencapaian' => $row['status'] ?? null,
                'penilaian_lanjut' => $row['catatan'] ?? null,
            ]);
        }

        // simpan ttd asesor
        $image_parts = explode(";base64,", $validated['ttd_asesor']);
        if (count($image_parts) < 2) {
            return back()->with('error', 'Format tanda tangan tidak valid.');
        }

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'ttd_asesor_' . time() . '.png';
        $filePath = 'public/ttd/' . $fileName;

        \Storage::put($filePath, $image_base64);

        ObservasiCeklisPersetujuan::create([
            'id_observasi' => $observasi->id_observasi,
            'tgl_ttd_asesor' => now(),
            'ttd_asesor' => $fileName,
        ]);

        // ✅ Redirect ke halaman detail peserta uji
        return redirect()->route('peserta.show', ['id' => $validated['id_asesi']])
                         ->with('success', 'Ceklis observasi & tanda tangan berhasil disimpan!');
    
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput();
    } catch (\Throwable $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}

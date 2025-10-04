<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesi;
use App\Models\SkemaSertifikasi;
use App\Models\Kuk;
use App\Models\ObservasiCeklis;
use App\Models\ObservasiCeklisItem;
use App\Models\KelompokPekerjaan;

class CeklisObservasiController extends Controller
{
    public function index()
    {
        $asesi = Asesi::all();
        $skema = SkemaSertifikasi::all();
        return view('ceklis_observasi', compact('asesi', 'skema'));
    }

    public function loadData($skemaId)
{
    // Ambil nama skema
    $skema = SkemaSertifikasi::find($skemaId);

    // Ambil semua kelompok + relasi unit → elemen → kuk
    $kelompok = KelompokPekerjaan::with(['unitKompetensi.elemen.kuk'])
        ->where('id_skema', $skemaId)
        ->get();

    return response()->json([
        'skema_nama' => $skema ? $skema->nama_skema : null,
        'kelompok'   => $kelompok,
    ]);
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_asesi' => 'required|exists:asesi,id_asesi',
            'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
            'kuk'      => 'required|array',
        ]);

        $observasi = ObservasiCeklis::create([
            'id_skema' => $validated['id_skema'],
            'id_asesor'=> auth()->id(),
            'id_asesi' => $validated['id_asesi'],
        ]);

        foreach ($validated['kuk'] as $kukId => $row) {
            $kuk = Kuk::with('elemen.unit')->findOrFail($kukId);

            ObservasiCeklisItem::create([
                'id_observasi'    => $observasi->id_observasi,
                'id_skema'        => $validated['id_skema'],
                'id_kelompok'     => $row['id_kelompok'] ?? null,
                'id_unit'         => $kuk->elemen->id_unit,
                'id_elemen'       => $kuk->id_elemen,
                'id_kuk'          => $kuk->id_kuk,
                'standar_industri'=> $row['standar_industri'] ?? null,
                'pencapaian'      => $row['status'] ?? null,
                'penilaian_lanjut'=> $row['catatan'] ?? null,
            ]);
        }

        return back()->with('success', 'Ceklis observasi berhasil disimpan.');
    }
}

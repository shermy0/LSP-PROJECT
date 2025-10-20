<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{RekamanAsesmen, HasilRekamanAsesmen, UnitKompetensi, Skema, Asesi};

class RekamanAsesmenController extends Controller
{
    // 📄 Tampilkan form pembuatan rekaman asesmen
    public function create($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);
        $unitKompetensi = UnitKompetensi::where('id_skema', $id_skema)->get();
        $asesis = Asesi::all(); // ambil semua asesi dari tabel Asesi

        return view('rekaman_asesmen_create', compact('skema', 'unitKompetensi', 'id_skema', 'asesis'));
    }

    // 💾 Simpan data rekaman asesmen
    public function store(Request $request)
    {
        $rekaman = RekamanAsesmen::create([
            'id_skema'        => $request->id_skema,
            'id_tuk'          => 1, // otomatis 1
            'id_asesi'        => $request->id_asesi,
            'id_asesor'       => $request->id_asesor,
            'hasil'           => strtoupper(trim($request->rekomendasi)), // aman
            'tindak_lanjut'   => $request->tindak_lanjut,
            'komentar_asesor' => $request->komentar,
        ]);

        foreach ($request->id_unit as $id_unit) {
            HasilRekamanAsesmen::create([
                'id_rekaman'              => $rekaman->id_rekaman,
                'id_unit'                 => $id_unit,
                'observasi'               => $request->observasi[$id_unit] ?? 0,
                'pernyataan_pihak_ketiga' => $request->pernyataan_pihak_ketiga[$id_unit] ?? 0,
                'pertanyaan_wawancara'    => $request->pertanyaan_wawancara[$id_unit] ?? 0,
                'pertanyaan_lisan'        => $request->pertanyaan_lisan[$id_unit] ?? 0,
                'pertanyaan_tertulis'     => $request->pertanyaan_tertulis[$id_unit] ?? 0,
                'proyek_kerja'            => $request->proyek_kerja[$id_unit] ?? 0,
                'lainnya'                 => $request->lainnya[$id_unit] ?? 0,
            ]);
        }

        return redirect()->route('rekap.asesmen', $request->id_skema)
                         ->with('success', 'Rekaman asesmen berhasil disimpan!');
    }

    // 📋 Tampilkan daftar rekaman asesmen berdasarkan skema
    public function index($id_skema = null)
    {
        if ($id_skema) {
            $rekamans = RekamanAsesmen::with(['asesi', 'asesor', 'detailHasil.unit'])
    ->where('id_skema', $id_skema)
    ->get();

            $skema = Skema::findOrFail($id_skema);
            return view('rekaman_asesmen_index', compact('rekamans', 'skema'));
        }

        $skemas = Skema::all();
        return view('rekaman_asesmen_select_skema', compact('skemas'));
    }

    // 👀 Tampilkan detail rekaman asesmen
    public function show($id)
    {
        $rekaman = RekamanAsesmen::with(['detailHasil.unit', 'asesi', 'asesor'])->findOrFail($id);
        return view('rekaman_asesmen_show', compact('rekaman'));
    }
}

<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use App\Models\SkemaSertifikasi;
use App\Models\UnitKompetensi;
use App\Models\HasilAsesmen;
use App\Models\HasilAsesmenBukti;
use App\Models\HasilAsesmenPerangkat;
use App\Models\MasterJenisBukti;
use App\Models\PerangkatAsesmen;
use App\Models\KelompokPekerjaan;
use Illuminate\Http\Request;


class MapaController extends Controller
{
    public function create()
    {
        $skemas = SkemaSertifikasi::where('status_skema', 'Aktif')->get();
        return view('form_perencanaan.form_mapa_01.mapa01', compact('skemas'));
    }

    public function getSkema($id)
    {
        $skema = SkemaSertifikasi::findOrFail($id);
        return response()->json($skema);
    }

    public function kodeUnit($skema_id)
    {
        $skema = SkemaSertifikasi::findOrFail($skema_id);

        $kelompokPekerjaan = KelompokPekerjaan::with([
                'hasilAsesmen.unit',
                'hasilAsesmen.bukti.jenisBukti',
                'hasilAsesmen.perangkat.perangkat'
            ])
            ->where('id_skema', $skema_id)
            ->get();

        return view('form_perencanaan.form_mapa_01.mapa01_kodeunit', compact('skema', 'kelompokPekerjaan'));
    }

public function tambahUnit($skema_id, $kelompok_id)
{
    $skema = SkemaSertifikasi::findOrFail($skema_id);
    $units = UnitKompetensi::where('id_skema', $skema_id)->get();

    $hasilAsesmen = HasilAsesmen::with('unit')
        ->whereHas('unit', function ($q) use ($skema_id) {
            $q->where('id_skema', $skema_id);
        })
        ->get();

    $jenisBukti = MasterJenisBukti::all();
    $perangkat = PerangkatAsesmen::with('jenisBukti')->get();

    return view('form_perencanaan.form_mapa_01.mapa01_kodeunit_add', compact(
        'skema',
        'units',
        'hasilAsesmen',
        'jenisBukti',
        'perangkat',
        'kelompok_id'
    ));
}


    public function getUnit($id)
{
    $unit = UnitKompetensi::findOrFail($id);
    return response()->json($unit);
}

public function searchUnit(Request $request)
{
    $query = $request->get('q');

    if (!$query) {
        // kalau query kosong, balikin 5 data awal biar suggestion tetap muncul
        $units = UnitKompetensi::limit(5)->get();
    } else {
        $units = UnitKompetensi::where('kode_unit', 'LIKE', "%{$query}%")
            ->orWhere('judul_unit', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();
    }

    return response()->json($units);
}
public function index($skema_id)
{
    
    $skema = SkemaSertifikasi::findOrFail($skema_id);
    return view('form_perencanaan.form_mapa_01.mapa01_konfirmasi', compact('skema'));
}

public function simpanUnit(Request $request, $skema_id, $kelompok_id)
{
    $request->validate([
        'kode_unit'   => 'required|exists:unit_kompetensi,id_unit',
        'bukti'       => 'nullable|string',
        'jenis_bukti' => 'nullable|array',
        'metode'      => 'nullable|array',
    ]);

    $hasil = new HasilAsesmen();
    $hasil->id_asesor    = auth()->id();
    $hasil->id_asesi     = 1;
    $hasil->id_unit      = $request->kode_unit;
    $hasil->id_kelompok  = $kelompok_id; // 🔥 assign ke kelompok pekerjaan
    $hasil->catatan      = $request->bukti;
    $hasil->status       = null;
    $hasil->save();

    if ($request->filled('jenis_bukti')) {
        foreach ($request->jenis_bukti as $idJenis) {
            HasilAsesmenBukti::create([
                'id_hasil' => $hasil->id_hasil,
                'id_jenis_bukti' => $idJenis
            ]);
        }
    }

    if ($request->filled('metode')) {
        foreach ($request->metode as $idPerangkat) {
            HasilAsesmenPerangkat::create([
                'id_hasil' => $hasil->id_hasil,
                'id_perangkat' => $idPerangkat
            ]);
        }
    }

    return redirect()->route('form.mapa01.kodeunit', $skema_id)
                     ->with('success', 'Unit berhasil ditambahkan.');
}

public function hapusUnit($skema_id, $id)
{
    $hasil = HasilAsesmen::findOrFail($id);
    $hasil->delete();

    return redirect()->route('form.mapa01.kodeunit', $skema_id)
                     ->with('success', 'Unit berhasil dihapus.');
}

public function tambahKelompok($skema_id)
{
    $skema = SkemaSertifikasi::findOrFail($skema_id);
    $jumlah = KelompokPekerjaan::where('id_skema', $skema_id)->count();

    KelompokPekerjaan::create([
        'id_skema' => $skema_id,
        'nama_kelompok' => 'Kelompok Pekerjaan ' . ($jumlah + 1),
    ]);

    return redirect()->route('form.mapa01.kodeunit', $skema_id)
                     ->with('success', 'Kelompok Pekerjaan baru ditambahkan.');
}

public function hapusKelompok($skema_id, $kelompok_id)
{
    $kelompok = KelompokPekerjaan::findOrFail($kelompok_id);
    $kelompok->delete();

    return redirect()->route('form.mapa01.kodeunit', $skema_id)
                     ->with('success', 'Kelompok Pekerjaan berhasil dihapus.');
}

}

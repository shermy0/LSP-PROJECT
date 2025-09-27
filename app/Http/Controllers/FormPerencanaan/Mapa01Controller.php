<?php

namespace App\Http\Controllers\FormPerencanaan;

use Illuminate\Support\Facades\DB;  
use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Models\TujuanAsesmen;
use App\Models\UnitKompetensi;
use App\Models\HasilAsesmen;
use App\Models\HasilAsesmenBukti;
use App\Models\HasilAsesmenPerangkat;
use App\Models\MasterJenisBukti;
use App\Models\PerangkatAsesmen;
use App\Models\KelompokPekerjaan;
use App\Models\KonfirmasiOrangRelevan;
use App\Models\KonfirmasiOrangRelevanPersetujuan;
use App\Models\LaporanAsesmen;
use App\Models\ValidasiAsesmen;
use App\Models\DasarAsesmen;
use Illuminate\Http\Request;


class Mapa01Controller extends Controller
{
public function showMapa01($id_skema)
{
    $skema = DB::table('skema_sertifikasi')->where('id_skema', $id_skema)->first();

    // Tujuan default
    $defaultTujuan = ['Sertifikasi', 'Pengakuan Kompetensi Terkini (PKT)', 'Rekognisi Pembelajaran Lampau (RPL)'];

    $allTujuan = DB::table('tujuan_asesmen')->pluck('nama_tujuan')->toArray();
    $customTujuan = array_diff($allTujuan, $defaultTujuan);

    $tujuanDipilih = DB::table('skema_tujuan')
        ->join('tujuan_asesmen', 'skema_tujuan.tujuan_id', '=', 'tujuan_asesmen.id_tujuan')
        ->where('skema_tujuan.skema_id', $id_skema)
        ->pluck('tujuan_asesmen.nama_tujuan')
        ->toArray();

    $pendekatan = DB::table('mapa01_pendekatan')->where('id_skema', $id_skema)->first();
$konteksRow = DB::table('mapa01_konteks')->where('id_skema', $id_skema)->first();

// Jadikan $konteks sebagai objek lengkap
$konteks = (object)[
    'lingkungan' => $konteksRow->lingkungan ?? '',
    'peluang'    => $konteksRow->peluang ?? '',
    'hubungan'   => $konteksRow && $konteksRow->hubungan ? json_decode($konteksRow->hubungan, true) : [],
    'pelaksana'  => $konteksRow && $konteksRow->pelaksana ? json_decode($konteksRow->pelaksana, true) : [],
];

    $konfirmasi = DB::table('mapa01_konfirmasi')->where('id_skema', $id_skema)->first();
$standarRow = DB::table('mapa01_standar_industri')
    ->where('id_skema', $id_skema)
    ->first();

$standar = (object)[
    'standar_kriteria_asesmen' => $standarRow->standar_kriteria_asesmen ?? 0,
    'standar_kinerja_perusahaan' => $standarRow->standar_kinerja_perusahaan ?? null,
    'standar_spesifikasi_produk' => $standarRow->standar_spesifikasi_produk ?? null,
    'standar_pedoman_khusus' => $standarRow->standar_pedoman_khusus ?? null,
];


    // 👉 Ambil standar_kompetensi pertama sesuai id_skema
    $standarKompetensi = DB::table('unit_kompetensi')
        ->where('id_skema', $id_skema)
        ->pluck('standar_kompetensi')
        ->unique()
        ->toArray();


    return view('form_perencanaan.form_mapa_01.mapa01', compact(
        'skema','defaultTujuan','customTujuan','tujuanDipilih','pendekatan',
    
        'konfirmasi','standar','standarKompetensi', 'konteks'
    ));
}

public function storeMapa01(Request $request, $id_skema)
{
    DB::beginTransaction();
    try {
        // === Tujuan Asesmen (sama seperti sebelumnya) ===
        if ($request->has('tujuan')) {
            // bersih-bersih: hapus dulu relasi lama supaya tidak duplikat
            DB::table('skema_tujuan')->where('skema_id', $id_skema)->delete();
            foreach ($request->tujuan as $namaTujuan) {
                $tujuan = DB::table('tujuan_asesmen')->where('nama_tujuan', $namaTujuan)->first();
                $tujuanId = $tujuan ? $tujuan->id_tujuan : DB::table('tujuan_asesmen')->insertGetId(['nama_tujuan' => $namaTujuan]);
                DB::table('skema_tujuan')->insert([
                    'skema_id' => $id_skema,
                    'tujuan_id' => $tujuanId,
                ]);
            }
        } else {
            // kalau tidak ada pilihan, hapus relasi lama (opsional)
            DB::table('skema_tujuan')->where('skema_id', $id_skema)->delete();
        }

        // === Pendekatan (sesuaikan nama field yang kamu pakai di blade) ===
        DB::table('mapa01_pendekatan')->updateOrInsert(
            ['id_skema' => $id_skema],
            [
                'pelatihan_standar'     => $request->has('pelatihan_standar') ? 1 : 0,
                'pelatihan_nonstandar'  => $request->has('pelatihan_nonstandar') ? 1 : 0,
                'pengalaman_standar'    => $request->has('pengalaman_standar') ? 1 : 0,
                'pengalaman_nonstandar' => $request->has('pengalaman_nonstandar') ? 1 : 0,
                'otodidak'              => $request->has('otodidak') ? 1 : 0,
            ]
        );

        // === KONTEKS: Lingkungan & Peluang radio, Hubungan & Pelaksana checkbox ===
        $lingkungan = $request->input('lingkungan', '');  // string
        $peluang    = $request->input('peluang', '');     // string
        $hubungan   = $request->input('hubungan', []);    // array
        $pelaksana  = $request->input('pelaksana', []);   // array

        DB::table('mapa01_konteks')->updateOrInsert(
            ['id_skema' => $id_skema],
            [
                'lingkungan' => $lingkungan,
                'peluang'    => $peluang,
                'hubungan'   => json_encode(array_values($hubungan)),
                'pelaksana'  => json_encode(array_values($pelaksana)),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // === Konfirmasi (sama seperti sebelumnya) ===
        DB::table('mapa01_konfirmasi')->updateOrInsert(
            ['id_skema' => $id_skema],
            [
                'konfirmasi_manajer_lsp'    => in_array('Manajer sertifikasi LSP P1 SMKN 11 Bandung', $request->orang_relevan ?? []) ? 1 : 0,
                'konfirmasi_master_asesor'  => in_array('Master Asesor / Master Trainer / Lead Asesor Kompetensi', $request->orang_relevan ?? []) ? 1 : 0,
                'konfirmasi_manajer_pelatihan' => in_array('Manajer Pelatihan Lembaga Training terakreditasi / Lembaga Training Terdaftar', $request->orang_relevan ?? []) ? 1 : 0,
                'konfirmasi_supervisor'     => in_array('Manajer atau supervisor di tempat kerja', $request->orang_relevan ?? []) ? 1 : 0,
            ]
        );

        // === Standar Industri ===
        DB::table('mapa01_standar_industri')->updateOrInsert(
            ['id_skema' => $id_skema],
            [
                'standar_kriteria_asesmen'   => $request->has('kriteria_asesmen') ? 1 : 0,
                'standar_kinerja_perusahaan' => $request->input('standar_kinerja_perusahaan') ?: null,
                'standar_spesifikasi_produk' => $request->input('spesifikasi_produk') ?: null,
                'standar_pedoman_khusus'     => $request->input('pedoman_khusus') ?: null,
            ]
        );

        DB::commit();
return redirect()->route('form.mapa01.kodeunit', ['skema_id' => $id_skema])
                 ->with('success', 'FR.MAPA.01 berhasil disimpan!');


        } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}

public function updateTujuan(Request $request, $skema_id, $tujuan_id)
{
    $request->validate([
        'nama_tujuan' => 'required|string|max:255',
    ]);

    DB::table('tujuan_asesmen')->where('id_tujuan', $tujuan_id)->update([
        'nama_tujuan' => $request->nama_tujuan,
    ]);

    return response()->json(['success' => true]);
}


public function deleteTujuan($id_skema, $id_tujuan)
{
    // Hapus relasi di skema_tujuan dulu
    DB::table('skema_tujuan')->where('tujuan_id', $id_tujuan)->delete();

    // Baru hapus tujuannya
    DB::table('tujuan_asesmen')->where('id_tujuan', $id_tujuan)->delete();

    // Kalau request AJAX, balikin JSON
    if (request()->wantsJson()) {
        return response()->json(['success' => true, 'message' => 'Tujuan berhasil dihapus']);
    }

    // Kalau request biasa (submit form), redirect
    return back()->with('success', 'Tujuan berhasil dihapus!');
}


public function konfirmasi($idSkema)
{
    $skema = Skema::findOrFail($idSkema);

    // Ambil role/jabatan yang sudah di-checklist di MAPA01
    $roles = Mapa01OrangRelevan::where('skema_id', $skema->id_skema)->pluck('jabatan');

    // Ambil asesor per skema
    $asesors = DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skema->id_skema)
        ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.jabatan')
        ->get();

    return view('form_perencanaan.form_mapa_01.mapa01_konfirmasi', compact('skema', 'roles', 'asesors'));
}




public function showSkema($id_skema)
{
    $skema = Skema::findOrFail($id_skema);
    $skemas = Skema::with('unitKompetensi')
        ->where('status_skema', 'Aktif')
        ->get();

    return view('form_perencanaan.form_mapa_01.mapa01', compact('skema','skemas'));
}


    public function getSkema($id)
    {
        $skema = Skema::findOrFail($id);
        return response()->json($skema);
    }

    public function kodeUnit($skema_id)
    {
        $skema = Skema::findOrFail($skema_id);

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
    $skema = Skema::findOrFail($skema_id);
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
    $skema = Skema::findOrFail($skema_id);
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

public function editUnit($skema_id, $id)
{
    $skema = Skema::findOrFail($skema_id);
    $hasil = HasilAsesmen::with(['unit','bukti','perangkat'])->findOrFail($id);

    $units = UnitKompetensi::where('id_skema', $skema_id)->get();
    $jenisBukti = MasterJenisBukti::all();
    $perangkat = PerangkatAsesmen::with('jenisBukti')->get();

    return view('form_perencanaan.form_mapa_01.mapa01_kodeunit_edit', compact(
        'skema',
        'hasil',
        'units',
        'jenisBukti',
        'perangkat'
    ));
}

public function updateUnit(Request $request, $skema_id, $id)
{
    $request->validate([
        'kode_unit'   => 'required|exists:unit_kompetensi,id_unit',
        'bukti'       => 'nullable|string',
        'jenis_bukti' => 'nullable|array',
        'metode'      => 'nullable|array',
    ]);

    $hasil = HasilAsesmen::findOrFail($id);
    $hasil->id_unit = $request->kode_unit;
    $hasil->catatan = $request->bukti;
    $hasil->save();

    // Hapus dulu relasi lama
    HasilAsesmenBukti::where('id_hasil', $hasil->id_hasil)->delete();
    HasilAsesmenPerangkat::where('id_hasil', $hasil->id_hasil)->delete();

    // Simpan ulang
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
                     ->with('success', 'Unit berhasil diperbarui.');
}

public function getUnitsBySkema($skema_id)
{
    $units = UnitKompetensi::where('id_skema', $skema_id)->get();
    return response()->json($units);
}

// BUAT NYARI ASESOR SESUAI SKEMA DI FILE KONFIRMASI
public function search(Request $request)
{
    $term = $request->get('q');
    $skemaId = $request->get('skema_id');

    $asesors = DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skemaId)
        ->where('asesor.nama_asesor', 'LIKE', "%{$term}%")
        ->select('asesor.id_asesor', 'asesor.nama_asesor')
        ->limit(10)
        ->get();

    return response()->json($asesors);
}



public function getKelompokBySkema($skemaId)
{
    $kelompok = KelompokPekerjaan::with('units')
                ->where('id_skema', $skemaId)
                ->get();

    return response()->json($kelompok);
}


// MapaController
public function createMapa02()
{
    $skemas = Skema::with(['kelompokPekerjaan.units'])->get();
    return view('mapa02', compact('skemas'));
}



}
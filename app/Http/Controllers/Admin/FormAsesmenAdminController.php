<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Skema;
use App\Models\Permohonan;
use App\Models\JawabanAsesmen;
use App\Models\KelompokPekerjaan;
use App\Models\UnitKompetensi;
use App\Models\PMO;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class FormAsesmenAdminController extends Controller
{

    // =====================
    // 1. HALAMAN SKEMA
    // =====================
    public function skema()
    {
        $skema = Skema::orderBy('nama_skema')->get();
        return view('admin.form-asesmen.skema', compact('skema'));
    }

    // =====================
    // 2. KATEGORI / TIPE
    // =====================
    public function kategori($skemaId)
    {
        $skema = Skema::findOrFail($skemaId);
        return view('admin.form-asesmen.kategori', compact('skema'));
    }

    // =====================
    // 3. DAFTAR ASESI
    // =====================
    public function asesi($skemaId, $tipe)
{
    $skema = DB::table('skema_sertifikasi')
        ->where('id_skema', $skemaId)
        ->first();

    if (!$skema) {
        abort(404);
    }

    // Ambil asesi yang sudah isi jawaban sesuai tipe
    $query = DB::table('asesi')
        ->join('users', 'users.id', '=', 'asesi.user_id')
        ->join('jawaban_asesmen', 'jawaban_asesmen.id_asesi', '=', 'asesi.id_asesi')
        ->join('pertanyaan', 'pertanyaan.id_pertanyaan', '=', 'jawaban_asesmen.id_pertanyaan')
        ->where('jawaban_asesmen.id_skema', $skemaId);

    if ($tipe == 'esai') {
        $query->where('pertanyaan.jenis_pertanyaan', 'esai')
              ->whereNotNull('jawaban_asesmen.jawaban_text');
    } 
    elseif ($tipe == 'pg') {
        $query->where('pertanyaan.jenis_pertanyaan', 'pilihan_ganda')
              ->whereNotNull('jawaban_asesmen.jawaban_opsi');
    } 
    elseif ($tipe == 'demonstrasi') { // revisi tipe demonstrasi
        $query->where('pertanyaan.jenis_pertanyaan', 'demonstrasi')
              ->whereNotNull('jawaban_asesmen.jawaban_text'); // atau kolom jawaban demonstrasi
    }
    elseif ($tipe == 'lisan') {
        $query->where('pertanyaan.jenis_pertanyaan', 'lisan');
    }

    $asesi = $query->select(
        'asesi.id_asesi',
        'users.name',
        'users.email'
    )->distinct()->get();

    return view('admin.form-asesmen.asesi', compact('asesi', 'skema', 'tipe', 'skemaId'));
}
    // =====================
    // 4. HASIL ASESMEN
    // =====================
    public function hasil($skemaId, $asesiId, $tipe)
    {
        $skema = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
        if (!$skema) abort(404, 'Skema tidak ditemukan.');

        $asesi = DB::table('asesi')
            ->join('users', 'users.id', '=', 'asesi.user_id')
            ->where('asesi.id_asesi', $asesiId)
            ->select('asesi.*', 'users.name', 'users.email')
            ->first();

        if (!$asesi) abort(404, 'Asesi tidak ditemukan.');

        $jawaban = JawabanAsesmen::where([
            'id_skema' => $skemaId,
            'id_asesi' => $asesiId
        ])->get();

        if ($jawaban->isEmpty() && $tipe !== 'praktik') {
            return back()->with('error', 'Belum ada jawaban dari asesi.');
        }

        // ======================
        // DATA ESAI
        // ======================
        $jawabanEsai = ($tipe === 'esai')
            ? $jawaban->whereNotNull('jawaban_text')
                      ->whereNull('jawaban_opsi')
                      ->values()
            : collect();

        // ======================
        // DATA PILIHAN GANDA
        // ======================
        $jawabanPg = collect();
        if ($tipe === 'pg') {
            $jawabanPg = DB::table('jawaban_asesmen as ja')
                ->join('opsi_jawaban as oj', 'ja.jawaban_opsi', '=', 'oj.id_opsi')
                ->select(
                    'ja.*',
                    'oj.kode_opsi',
                    'oj.isi_opsi',
                    DB::raw('(SELECT id_opsi FROM opsi_jawaban WHERE id_pertanyaan=ja.id_pertanyaan AND benar=1 LIMIT 1) as opsi_benar')
                )
                ->where('ja.id_skema', $skemaId)
                ->where('ja.id_asesi', $asesiId)
                ->whereNotNull('ja.jawaban_opsi')
                ->get();

    
        }

        // ======================
        // DATA PERTANYAAN LISAN
        // ======================
        $pertanyaan = collect();
        if ($tipe === 'lisan') {
            $pertanyaan = DB::table('pertanyaan as p')
                ->leftJoin('jawaban_asesmen as ja', function ($join) use ($skemaId, $asesiId) {
                    $join->on('p.id_pertanyaan', '=', 'ja.id_pertanyaan')
                         ->where('ja.id_skema', $skemaId)
                         ->where('ja.id_asesi', $asesiId);
                })
                ->where('p.jenis_pertanyaan', 'lisan')
                ->where('p.id_skema', $skemaId)
                ->select(
                    'p.id_pertanyaan',
                    'p.isi_pertanyaan',
                    'p.kunci_jawaban',
                    'ja.jawaban_text as jawaban_asesi'
                )
                ->get();
        }

// ======================
// DATA OBSERVASI
// ======================
$kelompok = KelompokPekerjaan::with('unitKompetensi.elemen.kuk')
    ->where('id_skema', $skemaId)
    ->get();

$observasi = null;
$hasilObservasi = new \stdClass();
$hasilObservasi->detail = [];

if ($tipe === 'observasi') {

    // ambil observasi terbaru
    $obs = DB::table('observasi_ceklis')
        ->where('id_skema', $skemaId)
        ->where('id_asesi', $asesiId)
        ->orderByDesc('id_observasi')
        ->first();

    if ($obs) {

        // ambil semua item observasi
        $items = DB::table('observasi_ceklis_item')
            ->where('id_observasi', $obs->id_observasi)
            ->get()
            ->keyBy('id_kuk'); // jadikan key berdasarkan id_kuk

foreach ($kelompok as $k) {
    foreach ($k->unitKompetensi as $uk) {
        foreach ($uk->elemen as $elemen) {
            foreach ($elemen->kuk as $kuk) {

                $item = $items[$kuk->id_kuk] ?? null;

                $hasilObservasi->detail[$kuk->id_kuk] = (object)[
                    'nama_elemen' => $elemen->nama_elemen ?? '-',
                    'deskripsi_kuk' => $kuk->deskripsi_kuk ?? '-',
                    'standar_industri' => $item->standar_industri ?? '-',
                    'status' => $item->pencapaian ?? '-',
                    'catatan' => $item->penilaian_lanjut ?? ''
                ];
            }
        }
    }
}

        // umpan balik
        $hasilObservasi->umpan_balik = $obs->umpan_balik ?? '';

        // tanda tangan
        $persetujuan = DB::table('observasi_ceklis_persetujuan')
            ->where('id_observasi', $obs->id_observasi)
            ->first();

        $hasilObservasi->tanggal_ttd_asesor = $persetujuan->tgl_ttd_asesor ?? null;
        $hasilObservasi->tanggal_ttd_asesi = $persetujuan->tgl_ttd_asesi ?? null;

        $observasi = (object)[
            'tanggal_asesmen' => $obs->created_at ?? null
        ];
    }
}

// ======================
// DATA PMO
// ======================
$unit = collect();
$pmoPertanyaan = [];
$form = null;

// ======================
// DATA PMO
// ======================
$unit = collect();
$pmoPertanyaan = [];

if ($tipe === 'pmo') {

$unit = DB::table('unit_kompetensi')
    ->join('hasil_asesmen', function($join) use ($asesiId) {
        $join->on('unit_kompetensi.id_unit', '=', 'hasil_asesmen.id_unit')
             ->where('hasil_asesmen.id_asesi', $asesiId);
    })
    ->select('unit_kompetensi.id_unit', 'unit_kompetensi.kode_unit', 'unit_kompetensi.judul_unit')
    ->orderBy('unit_kompetensi.kode_unit')
    ->get();
    
    // ambil semua tanggapan PMO dari asesi
    $listPmo = DB::table('pmo')
        ->where('id_asesi', $asesiId)
        ->get();

    // mapping pertanyaan per unit
    foreach ($unit as $u) {

        $pmoPertanyaan[$u->id_unit] = $listPmo
            ->filter(function($p) use ($u) {
                $kukIds = json_decode($p->id_kuk) ?? [];
                return in_array($u->id_unit, $kukIds);
            })
            ->map(function($r) {
                $pertanyaanList = DB::table('pmo_pertanyaan')
                    ->where('id_pmo', $r->id_pmo)
                    ->pluck('pertanyaan')
                    ->toArray();

                return (object)[
                    'pertanyaan' => implode(', ', $pertanyaanList),
                    'pencapaian' => $r->pencapaian ?? $r->umpan_balik_untuk_asesi
                ];
            })
            ->values();
    }

    // ambil form PMO terbaru untuk header & umpan balik
    $form = $listPmo->sortByDesc('id_pmo')->first();

    $hasil = (object)[
        'tuk' => $form->id_tuk ?? '-',
        'umpan_balik_untuk_asesi' => $form->umpan_balik_untuk_asesi ?? '-',
        'ttd_asesi' => $form->ttd_asesi ?? null,
        'ttd_asesor' => $form->ttd_asesor ?? null,
        'tanggal_ttd_asesi' => $form->tanggal_ttd_asesi ?? null,
        'tanggal_ttd_asesor' => $form->tanggal_ttd_asesor ?? null,
    ];
}

// ======================
// DATA PRAKTIK / DEMONSTRASI
// ======================
$demonstrasi = collect();  // default kosong
$jawabanAsesi = collect();

if ($tipe === 'praktik') {

    // ambil jawaban asesi jika ada
    $jawabanAsesi = DB::table('jawaban_demonstrasi')
        ->where('id_skema', $skemaId)
        ->where('id_asesi', $asesiId)
        ->get();

    if ($jawabanAsesi->isNotEmpty()) {
        // kalau ada jawaban, pakai itu untuk tampil
        $demonstrasi = $jawabanAsesi;
    } else {
        // kalau belum ada jawaban, ambil master tugas
        $demonstrasi = DB::table('master_tugas_demonstrasi')
            ->where('id_skema', $skemaId)
            ->get();
    }

    $view = 'admin.form-asesmen.hasil.hasil-praktik';
}

        // ======================
        // DATA ASESOR
        // ======================
        $asesor = DB::table('asesor')
            ->where('id_asesor', $asesi->asesor_id)
            ->first();

// ======================
// DATA HASIL (nilai dari asesor)
// ======================
$hasil = DB::table('jawaban_asesmen')
    ->where('id_skema', $skemaId)
    ->where('id_asesi', $asesiId)
    ->select('id_jawaban','id_pertanyaan','pencapaian')
    ->get();

        // ======================
        // HEADER & TTD
        // ======================
        $judulSkema = $skema->nama_skema ?? '-';
        $nomorSertifikat = $skema->kode_skema ?? '-';
        $waktuPenilaian = now()->format('H:i');
        $tanggalTTD = now()->format('d-m-Y');
        $noReg = $asesor->no_registrasi ?? '-';
        $namaTTD = $asesor->nama_asesor ?? '-';

        $namaFileAsesi = strtolower(str_replace(' ', '_', $asesi->name));
        $ttdAsesiFile = collect(glob(storage_path('app/public/ttd/ttd_asesmen_' . $namaFileAsesi . '_*.png')))
            ->sortByDesc(fn($file) => filemtime($file))
            ->first();
        $ttdAsesi = $ttdAsesiFile ? asset('storage/ttd/' . basename($ttdAsesiFile)) : null;

$namaAsesorFile = strtolower(str_replace(' ', '_', $asesor->nama_asesor));

$ttdAsesorFile = collect(glob(storage_path('app/public/ttd/*'.$namaAsesorFile.'*.png')))
    ->sortByDesc(fn($file) => filemtime($file))
    ->first();

$ttdAsesor = $ttdAsesorFile ? asset('storage/ttd/' . basename($ttdAsesorFile)) : null;
        // ======================
        // VIEW DEFAULT UNTUK TIPE LAIN
        // ======================
        if (!isset($view)) {
            if ($tipe === 'esai') $view = 'admin.form-asesmen.hasil.hasil-esai';
            elseif ($tipe === 'pg') $view = 'admin.form-asesmen.hasil.hasil-pg';
            elseif ($tipe === 'lisan') $view = 'admin.form-asesmen.hasil.hasil-lisan';
            elseif ($tipe === 'observasi') $view = 'admin.form-asesmen.hasil.hasil-observasi';
            elseif ($tipe === 'pmo') $view = 'admin.form-asesmen.hasil.hasil-pmo';
            else abort(404, 'Tipe asesmen tidak ditemukan.');
        }

$umpanBalik = '';

if ($tipe === 'esai') {
    // ambil umpan balik esai
// Ambil semua umpan balik esai dan gabungkan
$jawabanEsaiIds = $jawabanEsai->pluck('id_jawaban'); // ambil semua ID jawaban esai

$umpanBalik = DB::table('jawaban_asesmen_persetujuan')
    ->whereIn('id_jawaban', $jawabanEsaiIds)
    ->whereNotNull('umpan_balik')
    ->pluck('umpan_balik')       // ambil semua
    ->implode(' | ');    
}

if ($tipe === 'pg') {
    // Ambil ID jawaban PG
    $jawabanPgIds = $jawabanPg->pluck('id_jawaban');

    // Ambil umpan balik PG saja
    $umpanBalik = DB::table('jawaban_asesmen_persetujuan')
        ->whereIn('id_jawaban', $jawabanPgIds)
        ->whereNotNull('umpan_balik')
        ->pluck('umpan_balik')
        ->implode(' | ');
}

if ($tipe === 'observasi' && isset($hasilObservasi->umpan_balik)) {
    $umpanBalik = $hasilObservasi->umpan_balik;
}


        return view($view, compact(
            'asesi',
            'skema',
            'jawaban',
            'jawabanEsai',
            'jawabanPg',
            'pertanyaan',
            'kelompok',
            'unit',
            'pmoPertanyaan',
            'asesor',
            'hasil',
            'hasilObservasi',
            'jawabanAsesi',
            'demonstrasi',
            'observasi', // ← TAMBAHKAN INI
            'tipe',
            'judulSkema',
            'nomorSertifikat',
            'waktuPenilaian',
            'noReg',
            'namaTTD',
            'tanggalTTD',
            'ttdAsesi',
            'ttdAsesor',
            'umpanBalik'
        ));
    }

    // =====================
// 5. DOWNLOAD PDF
// =====================
public function downloadHasilPdf($skemaId, $asesiId, $tipe)
{
    $skema = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
    if (!$skema) abort(404, 'Skema tidak ditemukan.');

    $asesi = DB::table('asesi')
        ->join('users', 'users.id', '=', 'asesi.user_id')
        ->where('asesi.id_asesi', $asesiId)
        ->select('asesi.*', 'users.name', 'users.email')
        ->first();
    if (!$asesi) abort(404, 'Asesi tidak ditemukan.');

    if ($tipe === 'pilihan_ganda') $tipe = 'pg';

    // ======================
    // Inisialisasi variabel
    // ======================
    $jawabanEsai = collect();
    $jawabanPg = collect();
    $pertanyaan = collect();
    $jawabanAsesi = collect();
    $demonstrasi = collect();
    $unit = collect();
    $pmoPertanyaan = [];
    $kelompok = collect();
    $hasilObservasi = collect();
    $umpanBalik = '';
    $view = null;

    // ======================
    // Lisan
    // ======================
    if ($tipe === 'lisan') {
        $pertanyaan = DB::table('pertanyaan as p')
            ->leftJoin('jawaban_asesmen as ja', function ($join) use ($skemaId, $asesiId) {
                $join->on('p.id_pertanyaan', '=', 'ja.id_pertanyaan')
                     ->where('ja.id_skema', $skemaId)
                     ->where('ja.id_asesi', $asesiId);
            })
            ->where('p.jenis_pertanyaan', 'lisan')
            ->where('p.id_skema', $skemaId)
            ->select(
                'p.id_pertanyaan',
                'p.isi_pertanyaan',
                'p.kunci_jawaban',
                'ja.jawaban_text as jawaban_asesi'
            )
            ->get();

        $view = 'admin.form-asesmen.pdf.hasil-pdf-lisan';
    }

    // ======================
    // Esai
    // ======================
    if ($tipe === 'esai') {
        $jawabanEsai = JawabanAsesmen::where('id_skema', $skemaId)
            ->where('id_asesi', $asesiId)
            ->whereNotNull('jawaban_text')
            ->whereNull('jawaban_opsi')
            ->get();

        $jawabanIds = $jawabanEsai->pluck('id_jawaban');

        $umpanBalik = DB::table('jawaban_asesmen_persetujuan')
            ->whereIn('id_jawaban', $jawabanIds)
            ->whereNotNull('umpan_balik')
            ->pluck('umpan_balik')
            ->implode(' | ');

        $ttdPath = 'storage/ttd/ttd_asesor_8_esai_1773622856.png';
        $view = 'admin.form-asesmen.pdf.hasil-pdf-esai';
    }

    // ======================
    // Pilihan Ganda
    // ======================
    if ($tipe === 'pg') {
        $jawabanPg = DB::table('jawaban_asesmen as ja')
            ->join('opsi_jawaban as oj', 'ja.jawaban_opsi', '=', 'oj.id_opsi')
            ->select(
                'ja.*',
                'oj.kode_opsi',
                'oj.isi_opsi',
                DB::raw('(SELECT id_opsi FROM opsi_jawaban WHERE id_pertanyaan=ja.id_pertanyaan AND benar=1 LIMIT 1) as opsi_benar')
            )
            ->where('ja.id_skema', $skemaId)
            ->where('ja.id_asesi', $asesiId)
            ->get();

        $jawabanIds = $jawabanPg->pluck('id_jawaban');

        $umpanBalik = DB::table('jawaban_asesmen_persetujuan')
            ->whereIn('id_jawaban', $jawabanIds)
            ->whereNotNull('umpan_balik')
            ->pluck('umpan_balik')
            ->implode(' | ');

        $ttdPath = 'storage/ttd/ttd_asesor_8_pilihan_ganda_1773622826.png';
        $view = 'admin.form-asesmen.pdf.hasil-pdf-pg';
    }

    // ======================
    // Observasi
    // ======================
    if ($tipe === 'observasi') {
        $kelompok = DB::table('kelompok_pekerjaan')
            ->where('id_skema', $skemaId)
            ->get()
            ->map(function($kel) use ($skemaId) {
                $kel->unitKompetensi = DB::table('unit_kompetensi')
                    ->where('id_skema', $skemaId)
                    ->get()
                    ->map(function($unit) use ($skemaId) {
                        $unit->elemen = DB::table('elemen_kompetensi')
                            ->where('id_unit', $unit->id_unit)
                            ->get()
                            ->map(function($ele) {
                                $ele->kuk = DB::table('kuk')
                                    ->where('id_elemen', $ele->id_elemen)
                                    ->get();
                                return $ele;
                            });
                        return $unit;
                    });
                return $kel;
            });

        $obs = DB::table('observasi_ceklis')
            ->where('id_skema', $skemaId)
            ->where('id_asesi', $asesiId)
            ->orderByDesc('id_observasi')
            ->first();

        $hasilObservasi = new \stdClass();
        $hasilObservasi->detail = collect();

        if ($obs) {
            $items = DB::table('observasi_ceklis_item')
                ->where('id_observasi', $obs->id_observasi)
                ->get()
                ->keyBy('id_kuk');

            foreach ($kelompok as $kel) {
                foreach ($kel->unitKompetensi as $unit) {
                    foreach ($unit->elemen as $ele) {
                        foreach ($ele->kuk as $kuk) {
                            if (isset($items[$kuk->id_kuk])) {
                                $item = $items[$kuk->id_kuk];
                                $hasilObservasi->detail->push((object)[
                                    'nama_elemen' => $ele->nama_elemen,
                                    'nomor_elemen' => $ele->nomor_elemen ?? '',
                                    'deskripsi_kuk' => $kuk->deskripsi_kuk,
                                    'standar_industri' => $item->standar_industri ?? '-',
                                    'status' => $item->pencapaian ?? '-',
                                    'catatan' => $item->penilaian_lanjut ?? ''
                                ]);
                            }
                        }
                    }
                }
            }

            $hasilObservasi->umpan_balik = $obs->umpan_balik ?? '';
            $hasilObservasi->ttd_asesi = DB::table('observasi_ceklis_persetujuan')
                ->where('id_observasi', $obs->id_observasi)
                ->value('tgl_ttd_asesi');
            $hasilObservasi->ttd_asesor = DB::table('observasi_ceklis_persetujuan')
                ->where('id_observasi', $obs->id_observasi)
                ->value('tgl_ttd_asesor');
        }

        $view = 'admin.form-asesmen.pdf.hasil-pdf-observasi';
    }

    // ======================
    // Praktik / Demonstrasi
    // ======================
    if ($tipe === 'praktik') {
        $demonstrasi = DB::table('master_tugas_demonstrasi')
            ->where('id_skema', $skemaId)
            ->get();

        $jawabanAsesi = DB::table('jawaban_demonstrasi')
            ->where('id_skema', $skemaId)
            ->where('id_asesi', $asesiId)
            ->get();

        $view = 'admin.form-asesmen.pdf.hasil-pdf-praktik';
    }

    // ======================
    // PMO
    // ======================
    if ($tipe === 'pmo') {
        $unit = UnitKompetensi::orderBy('kode_unit')->get();
        $listPmo = PMO::where('id_asesi', $asesiId)->get();

        foreach ($unit as $u) {
            $pmoPertanyaan[$u->id_unit] = $listPmo
                ->filter(fn($p) => in_array($u->id_unit, json_decode($p->id_kuk)))
                ->map(function ($r) {
                    $pertanyaanList = DB::table('pmo_pertanyaan')
                        ->where('id_pmo', $r->id_pmo)
                        ->pluck('pertanyaan')
                        ->toArray();

                    return (object)[
                        'pertanyaan' => implode(', ', $pertanyaanList),
                        'tanggapan'  => $r->umpan_balik_untuk_asesi,
                    ];
                })
                ->toArray();
        }

        $view = 'admin.form-asesmen.pdf.hasil-pdf-pmo';
    }

    // ======================
    // Asesor & data tambahan PDF
    // ======================
    $asesor = DB::table('asesor')->where('id_asesor', $asesi->asesor_id)->first();
    if (!$asesor) {
        $asesor = (object)[
            'nama_asesor' => '-',
            'no_registrasi' => '-'
        ];
    }

    $judulSkema = $skema->nama_skema ?? '-';
    $nomorSertifikat = $skema->kode_skema ?? '-';
    $waktuPenilaian = now()->format('H:i');
    $tanggalTTD = now()->format('d-m-Y');
    $noReg = $asesor->no_registrasi ?? '-';
    $namaTTD = $asesor->nama_asesor ?? '-';

    $namaFileAsesi = strtolower(str_replace(' ', '_', $asesi->name));
    $ttdAsesiFile = collect(glob(storage_path('app/public/ttd/ttd_asesmen_' . $namaFileAsesi . '_*.png')))
        ->sortByDesc(fn($file) => filemtime($file))
        ->first();
    $ttdAsesi = $ttdAsesiFile ?? null;

    $namaAsesorFile = strtolower(str_replace(' ', '_', $asesor->nama_asesor));
    $ttdAsesorFile = collect(glob(storage_path('app/public/ttd/*'.$namaAsesorFile.'*.png')))
        ->sortByDesc(fn($file) => filemtime($file))
        ->first();
    $ttdAsesor = $ttdAsesorFile ?? null;

    // ======================
    // Generate PDF
    // ======================
    $pdf = Pdf::loadView($view, compact(
        'asesi','skema','jawabanEsai','jawabanPg','pertanyaan','asesor',
        'hasilObservasi','jawabanAsesi','demonstrasi','kelompok','unit','pmoPertanyaan',
        'judulSkema','nomorSertifikat','waktuPenilaian','noReg','namaTTD','tanggalTTD',
        'ttdAsesi','ttdAsesor','tipe','umpanBalik'
    ))->setPaper('A4','portrait');

    $filename = 'Hasil_Asesmen_' . $asesi->name . '_' . now()->format('Ymd') . '.pdf';
    return $pdf->download($filename);
}
}
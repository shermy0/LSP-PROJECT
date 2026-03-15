<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skema;
use App\Models\Asesor;
use App\Models\Asesi;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    
public function downloadPdfAdmin($skema_id, $asesor_id)
{
    // Ambil data asesor
    $asesor = DB::table('asesor')->where('id_asesor', $asesor_id)->first();

    // Ambil skema
    $skema  = DB::table('skema_sertifikasi')->where('id_skema', $skema_id)->first();

    // Ambil data TUK (sementara ambil yang pertama / aktif)
    $tuk = DB::table('tuk')->where('status_tuk', 'Aktif')->first();

    // Ambil daftar asesi + hasil + unit
    $asesis = DB::table('asesi')
        ->leftJoin('hasil_unit_kompetensi', 'asesi.id_asesi', '=', 'hasil_unit_kompetensi.id_asesi')
        ->leftJoin('unit_kompetensi', 'hasil_unit_kompetensi.id_unit', '=', 'unit_kompetensi.id_unit')
        ->where('asesi.asesor_id', $asesor_id)
        ->select(
            'asesi.nama_lengkap',
            'hasil_unit_kompetensi.hasil',
            'unit_kompetensi.kode_unit',
            'unit_kompetensi.judul_unit'
        )
        ->get();

    // Ambil catatan laporan asesmen
    $laporan = DB::table('laporan_asesmen')
        ->where('asesor_id', $asesor_id)
        ->where('skema_id', $skema_id)
        ->first();

    // Ambil data catatan & tanda tangan dari tabel penyusun_persetujuan
$penyusun = DB::table('penyusun_persetujuan')
    ->where('id_skema', $skema_id)
    ->where('id_asesor', $asesor_id)
    ->where('role', 'asesor')
    ->first();


    $view = 'form_perencanaan.admin_formperencanaan.laporan-pdf';

    // Generate PDF
$pdf = Pdf::loadView($view, compact('asesor', 'skema', 'tuk', 'asesis', 'laporan', 'penyusun'))
    ->setPaper('a4', 'portrait');

    $filename = 'Laporan_Asesmen_' . ($asesor->nama_asesor ?? 'unknown') . '.pdf';
    return $pdf->download($filename);
}


    public function showAdminLaporan($skema_id)
{
    $skema = \App\Models\Skema::findOrFail($skema_id);

    $asesors = \DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skema_id)
        ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi')
        ->get();

    return view('form_perencanaan.admin_formperencanaan.laporan-admin', compact('skema', 'asesors'));
}

    // tampilkan laporan per skema
    public function showLaporan($skema_id)
    {
        $skema = Skema::findOrFail($skema_id);

        // ambil asesor yang terkait skema ini lewat tabel pivot asesor_skema
        $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $skema_id)
            ->select('asesor.*')
            ->get();

        return view('form_perencanaan.laporan_asesmen.laporan', compact('skema', 'asesors'));
    }

public function showLaporanAsesor($skema_id)
{
    $skema = Skema::findOrFail($skema_id);

    // Ambil semua asesor terkait skema
    $asesors = DB::table('asesor')
        ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
        ->where('asesor_skema.skema_id', $skema_id)
        ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi as no_met')
        ->get();

    // Ambil asesor yang dipilih dari query string atau fallback ke pertama
    $asesor_terpilih = request()->query('asesor_id') 
        ?? session('asesor_terpilih') 
        ?? ($asesors->first()->id_asesor ?? null);

    // Ambil data TTD
    $ttd = DB::table('penyusun_persetujuan')
        ->where('id_skema', $skema_id)
        ->where('id_asesor', $asesor_terpilih)
        ->where('role', 'asesor')
        ->first();

    $no_registrasi_terpilih = $ttd->no_met ?? optional($asesors->firstWhere('id_asesor', $asesor_terpilih))->no_met;

    

    return view('form_perencanaan.laporan_asesmen.laporan_asesor', compact(
        'skema',
        'asesors',
        'asesor_terpilih',
        'ttd',
        'no_registrasi_terpilih'
    ));
}


    

    // ambil data asesi sesuai asesor & skema
public function getAsesiByAsesor($skema_id, $asesor_id)
{
    $asesis = DB::table('asesi')
        ->leftJoin('hasil_unit_kompetensi', 'asesi.id_asesi', '=', 'hasil_unit_kompetensi.id_asesi')
        ->where('asesi.asesor_id', $asesor_id)
        ->select(
            'asesi.id_asesi',
            'asesi.nama_lengkap',
            'hasil_unit_kompetensi.hasil',
            'hasil_unit_kompetensi.id_unit'
        )
        ->get();

$catatan = DB::table('laporan_asesmen')
    ->leftJoin('penyusun_persetujuan', function ($join) use ($asesor_id, $skema_id) {
        $join->on('laporan_asesmen.asesor_id', '=', 'penyusun_persetujuan.id_asesor')
             ->where('penyusun_persetujuan.id_skema', '=', $skema_id)
             ->where('penyusun_persetujuan.role', '=', 'asesor');
    })
    ->where('laporan_asesmen.skema_id', $skema_id)
    ->where('laporan_asesmen.asesor_id', $asesor_id)
    ->select(
        'laporan_asesmen.*',
        'penyusun_persetujuan.tanda_tangan',
        'penyusun_persetujuan.catatan as catatan'
    )
    ->first();


    return response()->json([
        'asesis'  => $asesis,
        'catatan' => $catatan,
    ]);
}


    // simpan catatan asesmen
public function store(Request $request)
{
    $skemaId  = $request->skema_id;
    $asesorId = $request->asesor_id;

    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'rekomendasi_')) {
            $asesiId = explode('_', $key)[1];
            $hasil   = $value;
            $unitId  = $request->input("keterangan_$asesiId");

            if ($hasil === 'BK' && empty($unitId)) {
                return back()->withErrors("Asesi $asesiId wajib pilih unit jika BK");
            }

            DB::table('hasil_unit_kompetensi')->updateOrInsert(
                ['id_asesi' => $asesiId],
                [
                    'id_unit'    => $hasil === 'K' ? null : $unitId,
                    'hasil'      => $hasil,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    DB::table('laporan_asesmen')->updateOrInsert(
        [
            'skema_id'  => $skemaId,
            'asesor_id' => $asesorId,
        ],
        [
            'aspek_positif_negatif' => $request->input('aspek_positif_negatif'),
            'penolakan'             => $request->input('penolakan'),
            'saran_perbaikan'       => $request->input('saran_perbaikan'),
            'tgl_laporan'           => $request->tanggal_asesmen,
            'updated_at'            => now(),
            'created_at'            => now(),
        ]
    );

    return redirect()
        ->route('form_perencanaan.laporan_asesmen.laporan_asesor', $skemaId)
        ->with('success', 'Laporan berhasil disimpan')
        ->with('asesor_terpilih', $asesorId)
        ->with('no_registrasi_terpilih', $request->no_registrasi);
}    
}

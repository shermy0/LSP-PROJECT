<?php

namespace App\Http\Controllers\FormPerencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\UnitKompetensi;
use App\Models\HasilAsesmen;
use App\Models\HasilAsesmenBukti;
use App\Models\HasilAsesmenPerangkat;
use App\Models\MasterJenisBukti;
use App\Models\PerangkatAsesmen;
use App\Models\KelompokPekerjaan;
use App\Models\InstrumenAsesmen;
use Illuminate\Support\Facades\DB;

class Mapa02Controller extends Controller
{
public function showMapa02Admin($id_skema)
{
    // Ambil data skema
    $skema = DB::table('skema_sertifikasi')
        ->where('id_skema', $id_skema)
        ->first();

    if (!$skema) {
        abort(404, 'Skema tidak ditemukan');
    }

    // Ambil data kelompok pekerjaan
    $kelompokPekerjaan = DB::table('kelompok_pekerjaan')
        ->where('id_skema', $id_skema)
        ->get();

    // Ambil hasil asesmen per kelompok
    foreach ($kelompokPekerjaan as $kelompok) {
        $kelompok->hasilAsesmen = DB::table('hasil_asesmen')
            ->where('id_kelompok', $kelompok->id_kelompok)
            ->get();

        // Ambil unit kompetensi tiap hasil asesmen (kalau ada kolom unit_id)
        foreach ($kelompok->hasilAsesmen as $hasil) {
            $hasil->unit = DB::table('unit_kompetensi')
                ->where('id_unit', $hasil->unit_id ?? null)
                ->first();
        }
    }

    // Ambil instrumen asesmen per kelompok
    $instrumenPerKelompok = DB::table('instrumen_asesmen')
        ->where('id_skema', $id_skema)
        ->get()
        ->keyBy('id_kelompok');

    // Ambil penyusun (MAPA.02)
    $penyusun = DB::table('penyusun_persetujuan')
        ->where('id_skema', $id_skema)
        ->where('form_type', 'mapa02')
        ->where('role', 'penyusun')
        ->get();

    // Ambil validator MAPA.02
    $validators = DB::table('validasi_validator')
        ->where('skema_id', $id_skema)
        ->get();

    // Ambil daftar asesor untuk dropdown atau referensi
    $asesors = DB::table('asesor')
        ->select('id_asesor', 'nama_asesor', 'no_registrasi as no_met')
        ->get();

    return view('form_perencanaan.admin_formperencanaan.mapa02-admin', compact(
        'skema',
        'kelompokPekerjaan',
        'instrumenPerKelompok',
        'penyusun',
        'validators',
        'asesors'
    ));
}

    
       public function storePenyusun(Request $request, $skema_id)
{
    if ($request->has('nama_asesor')) {
        foreach ($request->nama_asesor as $i => $idAsesor) {
            if (!$idAsesor) continue;

            $asesorData = DB::table('asesor')->where('id_asesor', $idAsesor)->first();
            $noMet = $asesorData->no_registrasi ?? ($request->nomet[$i] ?? null);

            $data = [
                'id_asesor' => $idAsesor,
                'no_met'    => $noMet,
                'tanggal'   => $request->tanggal[$i] ?? null,
                'role'      => 'penyusun',
                'form_type' => 'mapa02',
                'id_skema'  => $skema_id,
            ];

            if (!empty($request->tanda_tangan[$i])) {
                $data['tanda_tangan'] = $request->tanda_tangan[$i];
            }

            if (!empty($request->penyusun_id[$i])) {
                // update row lama (jika dari DB)
                DB::table('penyusun_persetujuan')
                    ->where('id', $request->penyusun_id[$i])
                    ->update($data);
            } else {
                // insert baru, **tidak peduli id_asesor sudah ada di MAPA.01**
                DB::table('penyusun_persetujuan')->insert($data);
            }
        }
    }

    return redirect()->back()->with('success', 'Data penyusun MAPA.02 berhasil disimpan.');
}


    /**
     * Hapus penyusun MAPA.02
     */
public function deletePenyusun($id)
{
    try {
        $deleted = DB::table('penyusun_persetujuan')
            ->where('id', $id)
            ->where('form_type', 'mapa02') // pastikan hanya hapus MAPA.02
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Penyusun MAPA.02 berhasil dihapus.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data penyusun MAPA.02 tidak ditemukan.'
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server.',
            'error'   => $e->getMessage()
        ], 500);
    }
}

    // Halaman MAPA02 default (tampilkan semua skema)
    public function index()
    {
        $skemas = Skema::all();
        return view('form_perencanaan.form_mapa_02.mapa02', compact('skemas'));
    }

    // Halaman MAPA02 berdasarkan skema
    public function showMapa02($skema_id)
{
    $skema = Skema::findOrFail($skema_id);

    $kelompokPekerjaan = KelompokPekerjaan::with([
        'hasilAsesmen.unit',
    ])->where('id_skema', $skema_id)->get();

    // ambil instrumen per kelompok
    $instrumenPerKelompok = InstrumenAsesmen::where('id_skema', $skema_id)
        ->get()
        ->keyBy('id_kelompok'); // biar nanti gampang diakses di Blade

    return view('form_perencanaan.form_mapa_02.mapa02', compact(
        'skema', 'kelompokPekerjaan', 'instrumenPerKelompok'
    ));
}



    // Ambil data asesor berdasarkan skema (AJAX)
    public function getAsesor($skemaId)
    {
        $skema = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
        if (!$skema) return response()->json([]);

        $asesors = DB::table('asesor')
            ->where('bidang_keahlian', $skema->bidang_keahlian)
            ->select('id_asesor', 'nama_asesor', 'no_registrasi')
            ->get();

        return response()->json($asesors);
    }

    // Ambil data asesi berdasarkan skema dan asesor (AJAX)
    public function getAsesi($skemaId, $asesorId)
    {
        $asesi = DB::table('asesi')
            ->where('asesor_id', $asesorId)
            ->select('id_asesi', 'nama_lengkap')
            ->get();

        return response()->json($asesi);
    }

    public function simpanInstrumen(Request $request)
{
    $skemaId = $request->input('skema_id');
    $kelompokIds = $request->input('id_kelompok', []);

    $fields = [
        'cek_observasi',
        'tugas_praktik',
        'tanya_observasi',
        'instruksi_tertulis',
        'soal_pg',
        'soal_esai',
        'soal_uraian',
        'cek_portofolio',
        'tanya_wawancara',
        'verifikasi_pihak3',
        'cek_produk',
    ];

    foreach ($kelompokIds as $idKelompok) {
        $data = ['id_skema' => $skemaId, 'id_kelompok' => $idKelompok];
        foreach ($fields as $field) {
            $data[$field] = $request->input("{$field}_{$idKelompok}", null);
        }

        DB::table('instrumen_asesmen')->updateOrInsert(
            ['id_skema' => $skemaId, 'id_kelompok' => $idKelompok],
            $data
        );
    }

return redirect()->route('form.mapa02.asesor', $skemaId)
                        ->with('success', 'Instrumen asesmen berhasil disimpan/diupdate.');}



    
public function showMapa02Asesor($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    // ambil semua asesor (buat dropdown)
 $asesors = DB::table('asesor')
            ->join('asesor_skema', 'asesor.id_asesor', '=', 'asesor_skema.asesor_id')
            ->where('asesor_skema.skema_id', $id_skema)
            ->select('asesor.id_asesor', 'asesor.nama_asesor', 'asesor.no_registrasi as no_met')
            ->get();
    // ambil data penyusun sesuai skema
   $penyusun = DB::table('penyusun_persetujuan')
    ->where('id_skema', $id_skema)
    ->where('role', 'penyusun')
    ->where('form_type', 'mapa02') // <-- hanya MAPA.01
    ->get();


        $validators = DB::table('validasi_validator')
        ->where('skema_id', $id_skema)
        ->get();

        

    return view('form_perencanaan.form_mapa_02.mapa02_asesor', compact(
        'skema',
        'asesors',
        'penyusun',
        'validators'
    ));
}


    // Ambil unit per skema (AJAX)
    public function getUnits($skemaId)
    {
        $units = UnitKompetensi::where('skema_id', $skemaId)->get();
        return response()->json($units);
    }
}

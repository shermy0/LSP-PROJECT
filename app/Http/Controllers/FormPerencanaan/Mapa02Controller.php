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
            ])
            ->where('id_skema', $skema_id)
            ->get();

        // ambil data instrumen asesmen
        $instrumen = DB::table('instrumen_asesmen')
            ->where('id_skema', $skema_id)
            ->first();

        return view('form_perencanaan.form_mapa_02.mapa02', compact('skema', 'kelompokPekerjaan', 'instrumen'));
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

        // mapping sesuai nama kolom di tabel
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

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $request->input($field, null);
        }

        DB::table('instrumen_asesmen')->updateOrInsert(
            ['id_skema' => $skemaId], // key pencarian
            $data // data yang diupdate/insert
        );

        return redirect()->route('form.mapa02.asesor', $skemaId)
                        ->with('success', 'Instrumen asesmen berhasil disimpan/diupdate.');
    }



    
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
        ->get();

        

    return view('form_perencanaan.form_mapa_02.mapa02_asesor', compact(
        'skema',
        'asesors',
        'penyusun'
    ));
}


    // Ambil unit per skema (AJAX)
    public function getUnits($skemaId)
    {
        $units = UnitKompetensi::where('skema_id', $skemaId)->get();
        return response()->json($units);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstrumenAsesmen;
use App\Models\LaporanAsesmen;
use App\Models\Skema;
use App\Models\Asesor;
use Carbon\Carbon;

class PerencanaanController extends Controller
{
    // 1️⃣ Form Perencanaan
    public function index()
    {
        $skemas = Skema::all();
        return view('formperencanaan', compact('skemas'));
    }

    public function simpan(Request $request)
    {
        $validPeriode = [
            'sebelum' => 'Sebelum Asesmen',
            'saat'    => 'Pada Saat Asesmen',
            'sesudah' => 'Setelah Asesmen'
        ];

        $periode = $request->query('periode');
        if (!array_key_exists($periode, $validPeriode)) abort(404);

        $periodeText = $validPeriode[$periode];
        $skema_id = $request->query('skema_id');
        $skema = $skema_id ? Skema::find($skema_id) : null;
        $skemas = Skema::all();

        // Ambil data hasil_validasi
        $hasilValidasi = DB::table('hasil_validasi')
                            ->where('skema_id', $skema_id)
                            ->get();

        $keterampilan = $hasilValidasi->whereNotNull('keterampilan')->first();
        $aspekList = $hasilValidasi->whereNotNull('aspek');

        return view('form_perencanaan.fr_va.fr_va_asesor', compact('periode', 'periodeText', 'skema_id', 'skemas', 'skema'));
    }

    // 2️⃣ Meninjau Asesmen
    public function ninjauAsesmenAsesor()
    {
        return view('ninjau_asesmen_asesor');
    }

    public function show($id)
    {
        $mapa02 = DB::table('mapa02')
                    ->where('id_mapa02', $id)
                    ->orWhere('id_asesmen', $id)
                    ->first();

        $currentSkemaId = $mapa02->skema_id ?? null;
        $skemas = Skema::all();
        $skema = $currentSkemaId ? Skema::find($currentSkemaId) : null;

        return view('ninjau_asesmen', compact('skemas', 'currentSkemaId', 'skema'));
    }

    // 3️⃣ Simpan Laporan Asesmen
    public function simpanLanjutLaporan(Request $request)
    {
        $request->validate([
            'aspek_positif_negatif' => 'nullable|string',
            'penolakan' => 'nullable|string',
            'saran_perbaikan' => 'nullable|string',
            'asesor_id' => 'required|exists:asesor,id_asesor',
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
            'no_registrasi' => 'required|string',
        ]);

        LaporanAsesmen::create([
            'aspek_positif_negatif' => $request->aspek_positif_negatif,
            'penolakan' => $request->penolakan,
            'saran_perbaikan' => $request->saran_perbaikan,
            'tgl_laporan' => now()->toDateString(),
            'asesor_id' => $request->asesor_id,
            'skema_id' => $request->skema_id,
            'no_registrasi' => $request->no_registrasi,
        ]);

        return redirect()->route('laporan_asesor.index')
                         ->with('success', 'Catatan asesmen berhasil disimpan!');
    }

    public function laporan()
    {
        $laporans = LaporanAsesmen::with(['asesor', 'skema'])->get();
        return view('laporan_asesor', compact('laporans'));
    }

    // 4️⃣ MAPA02
    public function mapa02(Request $request)
    {
        $skemaId = $request->skema_id; 
        $skema   = DB::table('skema_sertifikasi')->where('id_skema', $skemaId)->first();
        $instrumen = InstrumenAsesmen::all();

        if ($skemaId) {
            $instrumen = DB::table('skema_instrumen')
                ->join('instrumen_asesmen', 'skema_instrumen.instrumen_id', '=', 'instrumen_asesmen.id_instrumen')
                ->where('skema_instrumen.skema_id', $skemaId)
                ->select('instrumen_asesmen.*')
                ->get();
        }

        $skemas = DB::table('skema_sertifikasi')->get();

        return view('mapa02_asesor', compact('skemaId','skema','instrumen','skemas'));
    }

    public function simpanMapa02(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
        ]);

        DB::table('mapa02')->updateOrInsert(
            ['id_mapa02' => $request->id_mapa02],
            ['skema_id' => $request->skema_id]
        );

        return redirect()->route('ninjau_asesmen', ['id'=>$request->id_mapa02])
                         ->with('success', 'Skema berhasil disimpan ke MAPA02');
    }

    // 5️⃣ FR VA
    public function frVa(Request $request, $periode, $skema_id = null)
    {
        $validPeriode = [
            'sebelum' => 'Sebelum Asesmen',
            'saat'    => 'Pada Saat Asesmen',
            'sesudah' => 'Setelah Asesmen'
        ];

        if (!array_key_exists($periode, $validPeriode)) {
            abort(404);
        }

        $periodeText = $validPeriode[$periode];
        $skema_id = $skema_id ?? $request->query('skema_id');
        $skema = $skema_id ? Skema::find($skema_id) : null;
        $skemas = Skema::all();

        return view('form_perencanaan.fr_va.fr_va', compact('periode', 'periodeText', 'skema_id', 'skemas', 'skema'));
    }

    public function frVaAsesor(Request $request, $periode, $skema_id = null)
    {
        $skema  = Skema::find($skema_id);
        $skemas = Skema::all();
    
        if ($periode == 'sebelum') $periodeText = 'Sebelum';
        elseif ($periode == 'sesudah') $periodeText = 'Sesudah';
        else $periodeText = ucfirst($periode);
    
        return view('form_perencanaan.fr_va.fr_va_asesor', compact('periode','periodeText','skema','skemas','skema_id'));
    }     

    // 6️⃣ Simpan semua kontribusi, perbaikan, validator
    public function simpanSemua(Request $request)
    {
        $skema_id = $request->skema_id;

        // 1️⃣ Simpan Kontribusi
        foreach ($request->temuan as $index => $temuan) {
            $temuan = trim($temuan); // hapus spasi
            if(empty($temuan)) continue; // skip jika kosong
        
            $rekomendasi = $request->rekomendasi[$index] ?? '';
            DB::table('kontribusi')->insert([
                'skema_id' => $skema_id,
                'temuan' => $temuan,
                'rekomendasi' => $rekomendasi,
            ]);
        }        

        // 2️⃣ Simpan Perbaikan
        if ($request->perbaikan) {
            foreach ($request->perbaikan as $index => $kegiatan) {
                $waktu = $request->waktu[$index] ?? null;
                $penanggung = $request->penanggung[$index] ?? '';
                $ttdBase64 = $request->tanda_tangan[$index] ?? null;

                // Pastikan data base64 disimpan ke LONGTEXT
                $ttd = $ttdBase64 ? $ttdBase64 : 'Tidak ada';

                DB::table('rencana_perbaikan')->insert([
                    'skema_id' => $skema_id,
                    'kegiatan_perbaikan' => $kegiatan,
                    'waktu_penyelesaian' => $waktu,
                    'penanggung_jawab' => $penanggung,
                    'ttd' => $ttd,
                ]);
            }
        }

        // 3️⃣ Simpan Validator
        $nama_validators = $request->nama_validator ?? [];
        $no_registrasi = $request->no_registrasi ?? [];
        $tanggal = $request->tanggal_validator ?? [];
        $ttd = $request->tanda_tangan_validator ?? [];

        foreach ($nama_validators as $index => $nama) {
            if(empty($nama)) continue; // skip yang tidak dipilih
            DB::table('validasi_validator')->insert([
                'skema_id' => $skema_id,
                'nama_validator' => $nama,
                'no_registrasi' => $no_registrasi[$index] ?? null,
                'tanggal' => $tanggal[$index] ?? null,
                'ttd' => $ttd[$index] ?? null,
            ]);
        }

        return redirect()->route('formperencanaan.show', ['id_skema' => $skema_id])->with('success', 'Semua data berhasil disimpan!');
    }

    // 7️⃣ Laporan Asesmen
    public function store(Request $request)
    {
        LaporanAsesmen::create([
            'id_instrumen' => $request->skema_id,
            'aspek_positif_negatif' => $request->aspek_positif_negatif,
            'penolakan' => $request->penolakan,
            'saran_perbaikan' => $request->saran_perbaikan,
            'tgl_laporan' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('laporan_asesor')
                         ->with('success','Laporan asesmen berhasil disimpan.');
    }

    // 8️⃣ AJAX: ambil asesor sesuai skema
    public function getAsesor($skemaId)
    {
        $asesor = Asesor::where('skema_id', $skemaId)->get();
        return response()->json($asesor);
    }

    // 9️⃣ AJAX: ambil asesi sesuai skema & asesor
    public function getAsesi($skemaId, $asesorId)
    {
        $asesi = DB::table('asesi')
                    ->where('skema_id', $skemaId)
                    ->where('asesor_id', $asesorId)
                    ->get();
        return response()->json($asesi);
    }
}

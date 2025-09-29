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
        $id_skema = $request->skema_id;
    
        // simpan data sesuai kebutuhan...
    
        return redirect()->route('formperencanaan.show', ['id_skema' => $id_skema])
                         ->with('success', 'Data berhasil disimpan');
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

    public function simpanLanjutLaporan(Request $request)
    {
        $request->validate([
            'aspek_positif_negatif' => 'nullable|string',
            'penolakan' => 'nullable|string',
            'saran_perbaikan' => 'nullable|string',
            'asesor_id' => 'required',
            'skema_id' => 'required',
            'no_registrasi' => 'required',
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
    // Ambil semua laporan beserta relasi asesor & skema
    $laporans = LaporanAsesmen::with(['asesor', 'skema'])->get();

    return view('laporan_asesor', compact('laporans'));
}

    // 5️⃣ MAPA02
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

    // 6️⃣ FR VA
    public function frVa(Request $request, $periode, $skema_id = null)
{
    // Validasi periode
    $validPeriode = [
        'sebelum' => 'Sebelum Asesmen',
        'saat'    => 'Pada Saat Asesmen',
        'sesudah' => 'Setelah Asesmen'
    ];

    if (!array_key_exists($periode, $validPeriode)) {
        abort(404);
    }

    $periodeText = $validPeriode[$periode];

    // Ambil skema_id dari route jika ada, atau dari query string, default null
    if (!$skema_id) {
        $skema_id = $request->query('skema_id'); 
    }

    // Ambil skema yang dipilih sebelumnya
    $skema = $skema_id ? Skema::findOrFail($skema_id) : null;

    // Ambil semua skema untuk daftar FR.VA
    $skemas = Skema::all();

    return view('form_perencanaan.fr_va.fr_va', compact('periode', 'periodeText', 'skema_id', 'skemas', 'skema'));
}

public function frVaAsesor(Request $request)
{
    $periode = $request->query('periode', 'sebelum');
    $id_skema = $request->query('skema_id'); // cukup ID saja

    return view('form_perencanaan.fr_va.fr_va_asesor', compact('periode', 'id_skema'));
}

public function simpanLanjutfrVa(Request $request)
{
    // --- Simpan ke proses_validasi dan ambil id_validasi ---
    $id_validasi = \DB::table('proses_validasi')->insertGetId([
        'tujuan'          => $request->tujuan ? implode(", ", $request->tujuan) : null,
        'tujuan_lain'     => $request->tujuan_lain,
        'konteks'         => $request->konteks ? implode(", ", $request->konteks) : null,
        'konteks_lain'    => $request->konteks_lain,
        'pendekatan'      => $request->pendekatan ? implode(", ", $request->pendekatan) : null,
        'pendekatan_lain' => $request->pendekatan_lain,
    ]);

    // --- Simpan ke diskusi (orang relevan) ---
    $orangRelevan = $request->input('orangRelevan', []);
    if (!is_array($orangRelevan)) $orangRelevan = [$orangRelevan];

    $jabatanMap = [
        'asesorCheckbox'      => 'Asesor Kompetensi (wajib)',
        'leadCheckbox'        => 'Lead Asesor [Ketua TUK]',
        'managerCheckbox'     => 'Manager, Supervisor',
        'ahliCheckbox'        => 'Tenaga Ahli di bidangnya',
        'koordinatorCheckbox' => 'Koordinator Pelatihan',
        'anggotaCheckbox'     => 'Anggota Asosiasi Industry Profesi'
    ];

    foreach ($orangRelevan as $idCheckbox) {
        $namaArray = $request->input($idCheckbox.'_nama', []);
        $hasilArray= $request->input($idCheckbox.'_diskusi', []);

        if (is_array($namaArray)) {
            foreach ($namaArray as $index => $nama) {
                $asesor = \DB::table('asesor')->where('nama_asesor', $nama)->first();
                $id_asesor = $asesor ? $asesor->id_asesor : null;

                // insert diskusi dan ambil id_diskusi
                $id_diskusi = \DB::table('diskusi')->insertGetId([
                    'id_asesor'    => $id_asesor,
                    'nama_asesor'  => $nama,
                    'jabatan'      => $jabatanMap[$idCheckbox] ?? null,
                    'hasil_diskusi'=> $hasilArray[$index] ?? null,
                    'id_validasi'  => $id_validasi, // relasi ke proses_validasi
                ]);
            }
        }
    }

   // Ambil input checkbox
    $acuanArray  = $request->input('acuan', []);
    $dokumenArray = $request->input('dokumen', []);

    // Gabungkan acuan jadi string
    $acuanString = !empty($acuanArray) ? implode(", ", $acuanArray) : null;

    // Gabungkan dokumen sesuai acuan
    $dokumenString = null;
    if (!empty($dokumenArray)) {
        // misal dokumenArray = ['acuan1' => 'dok1', 'acuan2' => 'dok2']
        $dokumenString = implode(", ", $dokumenArray);
    }

    // Simpan ke tabel acuan_pembanding ---
    DB::table('acuan_pembanding')->insert([
        'id_validasi' => $id_validasi,
        'skema_id'    => $request->skema_id,
        'acuan'       => $acuanString,
        'dokumen'     => $dokumenString,
    ]);

    // --- Simpan keterampilan komunikasi ---
    $skills = $request->input('keterampilan', []); // ["Pro Aktif", "Empati", ...]
    if (!empty($skills)) {
        \DB::table('hasil_validasi')->insert([
            'id_validasi'  => $id_validasi,
            'keterangan'   => 'Keterampilan komunikasi yang digunakan dalam kegiatan validasi',
            'keterampilan' => json_encode($skills),
        ]);
    }

    // --- Simpan aspek kegiatan validasi ---
    if ($request->has('aspek')) {
        $aspekList = [
            'Rencana Asesmen',
            'Interpretasi Standar Kompetensi',
            'Interpretasi Acuan Pembanding lainnya',
            'Proses Asesmen',
            'Penyeleksian dan Penerapan Metode Asesmen',
            'Penyeleksian dan Penerapan Perangkat Asesmen',
            'Bukti-bukti yang Dikumpulkan',
            'Pengambilan Keputusan'
        ];

        $aturanMap  = [1 => 'V', 2 => 'A', 3 => 'T', 4 => 'M'];
        $prinsipMap = [5 => 'V', 6 => 'R', 7 => 'F', 8 => 'F'];

        foreach ($request->aspek as $index => $checks) {
            $aturan  = [];
            $prinsip = [];

            foreach ($checks as $pos => $val) {
                if ($val == "on") {
                    if (isset($aturanMap[$pos]))  $aturan[]  = $aturanMap[$pos];
                    if (isset($prinsipMap[$pos])) $prinsip[] = $prinsipMap[$pos];
                }
            }

            \DB::table('hasil_validasi')->insert([
                'id_validasi'     => $id_validasi,
                'aspek'           => $aspekList[$index] ?? null,
                'aturan_bukti'    => implode(', ', $aturan),
                'prinsip_asesmen' => implode(', ', $prinsip),
            ]);
        }
    }
    
    return redirect()->route('form_perencanaan.fr_va_asesor', ['periode' => $request->periode])
    ->with('success', 'Data berhasil disimpan!');
}

    // 7️⃣ Simpan laporan asesmen
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
        $asesor = Asesor::where('skema_id',$skemaId)->get();
        return response()->json($asesor);
    }

    // 9️⃣ AJAX: ambil asesi sesuai skema & asesor
    public function getAsesi($skemaId,$asesorId)
    {
        $asesi = DB::table('asesi')
                    ->where('skema_id',$skemaId)
                    ->where('asesor_id',$asesorId)
                    ->get();
        return response()->json($asesi);
    }
}
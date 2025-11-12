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

    // 5️⃣ FR VA (Form)
    public function frva(Request $request, $periode, $skema_id)
    {
        // validasi urutan isi
        $sebelum = DB::table('proses_validasi')->where('skema_id', $skema_id)->where('periode','sebelum')->exists();
        $saat    = DB::table('proses_validasi')->where('skema_id', $skema_id)->where('periode','saat')->exists();

        if ($periode === 'saat' && !$sebelum) {
            return redirect()->back()->with('error', 'Harap isi dulu bagian Sebelum Asesmen.');
        }
        if ($periode === 'sesudah' && !$saat) {
            return redirect()->back()->with('error', 'Harap isi dulu bagian Saat Asesmen.');
        }

        $periodeText = $periode === 'sebelum' ? 'Sebelum' : ($periode === 'saat' ? 'Saat' : 'Sesudah');
        $skema  = Skema::find($skema_id);
        $skemas = Skema::all();

        // Ambil data sebelumnya jika ada (untuk checked di form)
        $prosesValidasi = DB::table('proses_validasi')
                            ->where('skema_id', $skema_id)
                            ->where('periode', $periode)
                            ->first();

        $tujuanSelected     = $prosesValidasi && $prosesValidasi->tujuan ? explode(', ', $prosesValidasi->tujuan) : [];
        $konteksSelected    = $prosesValidasi && $prosesValidasi->konteks ? explode(', ', $prosesValidasi->konteks) : [];
        $pendekatanSelected = $prosesValidasi && $prosesValidasi->pendekatan ? explode(', ', $prosesValidasi->pendekatan) : [];

        // Variabel "lainnya"
        $tujuanLain     = $prosesValidasi->tujuan_lain ?? '';
        $konteksLain    = $prosesValidasi->konteks_lain ?? '';
        $konteksLain2   = $prosesValidasi->konteks_lain2 ?? '';
        $dokumenLain1   = $prosesValidasi->dokumen_lain1 ?? '';
        $dokumenLain2   = $prosesValidasi->dokumen_lain2 ?? '';

        return view('form_perencanaan.fr_va.fr_va', compact(
            'periode',
            'periodeText',
            'skema_id',
            'skemas',
            'skema',
            'tujuanSelected',
            'konteksSelected',
            'pendekatanSelected',
            'tujuanLain',
            'konteksLain',
            'konteksLain2',
            'dokumenLain1',
            'dokumenLain2'
        ));
    }

    // 5.1️⃣ FR VA Asesor (Form Asesor)
    public function frVaAsesor(Request $request, $periode, $skema_id = null)
    {
        $skema  = Skema::find($skema_id);
        $skemas = Skema::all();
    
        $periodeText = $periode == 'sebelum' ? 'Sebelum' : ($periode == 'sesudah' ? 'Sesudah' : ucfirst($periode));
    
        return view('form_perencanaan.fr_va.fr_va_asesor', compact('periode','periodeText','skema','skemas','skema_id'));
    }     

    public function simpanLanjutfrVa(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
        ]);

        $skema_id = $request->input('skema_id');

        // 🔹 Tentukan periode berikutnya secara otomatis
        $urutanPeriode = ['sebelum', 'saat', 'sesudah'];

        $lastPeriode = DB::table('proses_validasi')
                        ->where('skema_id', $skema_id)
                        ->orderByRaw("FIELD(periode, 'sebelum','saat','sesudah') DESC")
                        ->value('periode');

        $nextPeriode = 'sebelum'; // default jika belum ada
        if ($lastPeriode) {
            $index = array_search($lastPeriode, $urutanPeriode);
            $nextPeriode = $urutanPeriode[$index + 1] ?? null;
        }

        if (!$nextPeriode) {
            return redirect()->back()->with('error', 'Semua periode sudah diisi.');
        }

        // 🔹 Simpan proses_validasi
        $id_validasi = DB::table('proses_validasi')->insertGetId([
            'skema_id'       => $skema_id,
            'periode'        => $nextPeriode, // otomatis
            'tujuan'         => is_array($request->tujuan) ? implode(", ", $request->tujuan) : $request->tujuan,
            'tujuan_lain'    => $request->tujuan_lain ?? null,
            'konteks'        => is_array($request->konteks) ? implode(", ", $request->konteks) : $request->konteks,
            'konteks_lain'   => $request->konteks_lain ?? null,
            'pendekatan'     => is_array($request->pendekatan) ? implode(", ", $request->pendekatan) : $request->pendekatan,
            'pendekatan_lain'=> $request->pendekatan_lain ?? null,
        ]);

        // 🔹 Simpan orang relevan
        $orangRelevan = $request->input('orangRelevan', []);
        $jabatanMap = [
            'asesorCheckbox'      => 'Asesor Kompetensi (wajib)',
            'leadCheckbox'        => 'Lead Asesor [Ketua TUK]',
            'managerCheckbox'     => 'Manager, Supervisor',
            'ahliCheckbox'        => 'Tenaga Ahli di bidangnya',
            'koordinatorCheckbox' => 'Koordinator Pelatihan',
            'anggotaCheckbox'     => 'Anggota Asosiasi Industry Profesi'
        ];

        foreach ($orangRelevan as $idCheckbox) {
            $namaArray  = (array) $request->input($idCheckbox.'_nama', []);
            $hasilArray = (array) $request->input($idCheckbox.'_diskusi', []);

            $namaGabung  = [];
            $hasilGabung = [];

            foreach ($namaArray as $index => $nama) {
                if (!empty($nama)) {
                    $namaGabung[]  = $nama;
                    $hasilGabung[] = $hasilArray[$index] ?? '';
                }
            }

            if (!empty($namaGabung)) {
                DB::table('diskusi')->insert([
                    'skema_id'      => $skema_id,
                    'nama_asesor'   => implode(", ", $namaGabung),
                    'jabatan'       => $jabatanMap[$idCheckbox] ?? '-',
                    'hasil_diskusi' => implode(" | ", $hasilGabung),
                    'id_validasi'   => $id_validasi,
                ]);
            }
        }

        // 🔹 Simpan acuan pembanding
        $acuanArray   = $request->input('acuan', []);
        $dokumenArray = $request->input('dokumen', []);
        DB::table('acuan_pembanding')->insert([
            'id_validasi' => $id_validasi,
            'skema_id'    => $skema_id,
            'acuan'       => !empty($acuanArray) ? implode(", ", $acuanArray) : null,
            'dokumen'     => !empty($dokumenArray) ? implode(", ", $dokumenArray) : null,
        ]);

        // 🔹 Simpan keterampilan komunikasi
        $skills = $request->input('keterampilan', []);
        $keterampilanJson = !empty($skills) ? json_encode($skills) : '[]';

        // 🔹 Simpan aspek kegiatan dengan aturan & prinsip
        if ($request->has('aspek')) {
            $aspekList = [
                0 => 'Keterampilan komunikasi yang digunakan dalam kegiatan validasi',
                1 => 'Rencana Asesmen',
                2 => 'Interpretasi Standar Kompetensi',
                3 => 'Interpretasi Acuan Pembanding lainnya',
                4 => 'Proses Asesmen',
                5 => 'Penyeleksian dan Penerapan Metode Asesmen',
                6 => 'Penyeleksian dan Penerapan Perangkat Asesmen',
                7 => 'Bukti-bukti yang Dikumpulkan',
                8 => 'Pengambilan Keputusan'
            ];

            $aturanMap  = [1 => 'V', 2 => 'A', 3 => 'T', 4 => 'M'];
            $prinsipMap = [5 => 'F', 6 => 'R', 7 => 'F', 8 => 'F'];

            foreach ($request->aspek as $index => $checks) {
                $aturan = [];
                $prinsip = [];

                foreach ($checks as $pos => $val) {
                    if ($val === "on") {
                        if (isset($aturanMap[$pos])) $aturan[] = $aturanMap[$pos];
                        if (isset($prinsipMap[$pos])) $prinsip[] = $prinsipMap[$pos];
                    }
                }

                DB::table('hasil_validasi')->insert([
                    'id_validasi'     => $id_validasi,
                    'skema_id'        => $skema_id,
                    'user_id'         => auth()->id(), 
                    'keterangan'      => $index === 0 ? $keterampilanJson : null,
                    'aspek'           => $aspekList[$index] ?? null,
                    'aturan_bukti'    => !empty($aturan) ? implode(", ", $aturan) : null,
                    'prinsip_asesmen' => !empty($prinsip) ? implode(", ", $prinsip) : null,
                ]);                
            }
        }

        return redirect()->route('form_perencanaan.fr_va_asesor', [
            'periode' => $nextPeriode,
            'skema_id' => $skema_id
        ])->with('success', "Data periode '{$nextPeriode}' berhasil disimpan!");        
    }  

    // 5.2️⃣ Simpan FR VA + Asesor
    public function simpanFrVa(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
            'nama'     => 'required|string|max:100',
            'keterangan' => 'nullable|string',
            'asesor.*.nama_asesor' => 'required|string|max:100',
            'asesor.*.jabatan' => 'nullable|string|max:100',
        ]);

        // simpan FR VA utama
        $frvaId = DB::table('fr_va')->insertGetId([
            'skema_id'   => $request->skema_id,
            'nama'       => $request->nama,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // simpan asesor
        if ($request->has('asesor')) {
            foreach ($request->asesor as $asesor) {
                DB::table('fr_va_asesor')->insert([
                    'fr_va_id'     => $frvaId,
                    'nama_asesor'  => $asesor['nama_asesor'],
                    'jabatan'      => $asesor['jabatan'] ?? null,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        return redirect()->back()->with('success','FR VA berhasil disimpan!');
    }

    // 6️⃣ Simpan semua kontribusi, perbaikan, validator
    public function simpanSemua(Request $request)
    {
        $skema_id = $request->skema_id;

        // 1️⃣ Simpan Kontribusi
        foreach ($request->temuan as $index => $temuan) {
            $temuan = trim($temuan);
            if(empty($temuan)) continue;
        
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
        $no_registrasi   = $request->no_registrasi ?? [];
        $tanggal         = $request->tanggal_validator ?? [];
        $ttd             = $request->tanda_tangan_validator ?? [];

        foreach ($nama_validators as $index => $nama) {
            if(empty($nama)) continue;
            DB::table('validasi_validator')->insert([
                'skema_id' => $skema_id,
                'nama_validator' => $nama,
                'no_registrasi' => $no_registrasi[$index] ?? null,
                'tanggal' => $tanggal[$index] ?? null,
                'ttd' => $ttd[$index] ?? null,
            ]);
        }

        return redirect()->route('formperencanaan.show', ['id_skema' => $skema_id])
                         ->with('success', 'Semua data berhasil disimpan!');
    }

    // 7️⃣ Laporan Asesmen (store manual)
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
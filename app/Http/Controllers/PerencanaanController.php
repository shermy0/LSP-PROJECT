<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InstrumenAsesmen;
use App\Models\LaporanAsesmen;
use App\Models\Skema;
use App\Models\Asesor;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProsesValidasi;
use App\Models\Diskusi;
use App\Models\AcuanPembanding;
use App\Models\HasilValidasi;

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
            'sesudah' => 'Sesudah Asesmen'
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
        $sesudah    = DB::table('proses_validasi')->where('skema_id', $skema_id)->where('periode','sesudah')->exists();

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
        $acuanLain1     = $prosesValidasi->acuan_lain1 ?? '';
        $dokumenLain1   = $prosesValidasi->dokumen_lain1 ?? '';
        $dokumenLain2   = $prosesValidasi->dokumen_lain2 ?? '';
        $dokumenLain3   = $prosesValidasi->dokumen_lain3 ?? '';
        $dokumenLain4   = $prosesValidasi->dokumen_lain4 ?? '';

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
            'acuanLain1',
            'dokumenLain1',
            'dokumenLain2',
            'dokumenLain3',
            'dokumenLain4'
        ));
    }

    // 5.1️⃣ FR VA Asesor (Form Asesor)
    public function frVaAsesor(Request $request, $periode, $skema_id = null)
    {
        $skema  = Skema::find($skema_id);
        $skemas = Skema::all();
        $periodeText = $periode == 'sebelum' ? 'Sebelum' : ($periode == 'sesudah' ? 'Sesudah' : ucfirst($periode));

        // ambil fr_va dari session
        $frvaId = session('frva_id');
        $frvaData = $frvaId ? DB::table('fr_va')->where('id', $frvaId)->first() : null;

        // ambil asesor terkait fr_va jika ada
        $asesors = $frvaId ? DB::table('fr_va_asesor')->where('fr_va_id', $frvaId)->get() : collect();

        return view('form_perencanaan.fr_va.fr_va_asesor', compact('periode','periodeText','skema','skemas','skema_id','frvaData','asesors'));
    }   

    public function simpanLanjutfrVa(Request $request)
    {
        $request->validate([
            'skema_id' => 'required|exists:skema_sertifikasi,id_skema',
        ]);

        $skema_id = $request->input('skema_id');

        // urutan periode
        $urutanPeriode = ['sebelum', 'saat', 'sesudah'];

        $lastPeriode = DB::table('proses_validasi')
            ->where('skema_id', $skema_id)
            ->orderByRaw("FIELD(periode, 'sebelum','saat','sesudah') DESC")
            ->value('periode');

        $nextPeriode = 'sebelum';
        if ($lastPeriode) {
            $index = array_search($lastPeriode, $urutanPeriode);
            $nextPeriode = $urutanPeriode[$index + 1] ?? null;
        }

        if (!$nextPeriode) {
            return back()->with('error', 'Semua periode sudah diisi.');
        }

        // Siapkan konteks lain (bisa lebih dari satu)
        $konteksLain = $request->konteks_lain;

        if (is_array($konteksLain)) {
            // Hanya simpan yang tidak kosong
            $konteksLain = array_filter($konteksLain);

            $konteksLain = json_encode(array_values($konteksLain));
        } else {
            $konteksLain = null;
        }

        $id_validasi = DB::table('proses_validasi')->insertGetId([
            'skema_id'        => $skema_id,
            'periode'         => $nextPeriode,

            'tujuan'          => is_array($request->tujuan)
                                    ? implode(", ", $request->tujuan)
                                    : $request->tujuan,

            'tujuan_lain'     => $request->tujuan_lain ?? null,

            'konteks'         => is_array($request->konteks)
                                    ? implode(", ", $request->konteks)
                                    : $request->konteks,

            'konteks_lain'    => $konteksLain, // <= JSON berisi beberapa nilai

            'pendekatan'      => is_array($request->pendekatan)
                                    ? implode(", ", $request->pendekatan)
                                    : $request->pendekatan,

            'pendekatan_lain' => $request->pendekatan_lain ?? null,
        ]);

        $orangRelevan = $request->input('orangRelevan', []);

        $jabatanMap = [
            'asesorCheckbox'      => 'Asesor Kompetensi (wajib)',
            'leadCheckbox'        => 'Lead Asesor [Ketua TUK]',
            'managerCheckbox'     => 'Manager, Supervisor',
            'ahliCheckbox'        => 'Tenaga Ahli di bidangnya',
            'koordinatorCheckbox' => 'Koordinator Pelatihan',
            'anggotaCheckbox'     => 'Anggota Asosiasi Industry Profesi'
        ];

        // hasil diskusi satu untuk semua nama dalam setiap jabatan
        $hasilDiskusi = $request->hasil_diskusi_global;

        foreach ($orangRelevan as $idCheckbox) {

            // Semua nama dalam jabatan ini
            $namaArray = (array) $request->input($idCheckbox . '_nama', []);

            // Bersihkan data kosong
            $namaGabung = array_filter($namaArray);

            if (!empty($namaGabung)) {
                DB::table('diskusi')->insert([
                    'skema_id'      => $skema_id,
                    'nama_asesor'   => implode(", ", $namaGabung), // semua orang dalam jabatan ini
                    'jabatan'       => $jabatanMap[$idCheckbox] ?? '-',
                    'hasil_diskusi' => $hasilDiskusi,             // hasil diskusi global
                    'id_validasi'   => $id_validasi,
                ]);
            }
        }

        // Ambil checkbox utama
        $acuanArray   = $request->input('acuan', []);
        $dokumenArray = $request->input('dokumen', []);

        // Ambil input acuan lain
        $acuanLain1 = (array) $request->input('acuan_lain1', []);

        // Ambil input dokumen lain (dinamis)
        $dokumenLain1 = (array) $request->input('dokumen_lain', []);
        $dokumenLain2 = (array) $request->input('dokumen_lain2', []);
        $dokumenLain3 = (array) $request->input('dokumen_lain3', []);
        $dokumenLain4 = (array) $request->input('dokumen_lain4', []);

        // Gabungkan semua acuan
        $allAcuan = array_filter(array_merge(
            $acuanArray,
            $acuanLain1
        ));

        // Gabungkan semua dokumen
        $allDokumen = array_filter(array_merge(
            $dokumenArray,
            $dokumenLain1,
            $dokumenLain2,
            $dokumenLain3,
            $dokumenLain4
        ));

        // Simpan
        DB::table('acuan_pembanding')->insert([
            'id_validasi'     => $id_validasi,
            'skema_id'        => $skema_id,
            'acuan'           => !empty($acuanArray) 
                                    ? implode(", ", $acuanArray) 
                                    : null,
            'dokumen'         => !empty($dokumenArray) 
                                    ? implode(", ", $dokumenArray) 
                                    : null,
            'acuan_lain'=> !empty($request->acuan_lain)
                            ? implode(", ", $request->acuan_lain)
                            : null,                
            'dokumen_lain' => collect([
                                        $request->dokumen_lain,
                                        $request->dokumen_lain2,
                                        $request->dokumen_lain3,
                                        $request->dokumen_lain4,
                                    ])->flatten()->filter()->join(', '),
        ]);         

        // KETERAMPILAN KOMUNIKASI
        $skills = $request->input('keterampilan', []);
        $keterampilanJson = !empty($skills) ? json_encode($skills) : null;

        // HASIL VALIDASI - ASPEK
        if ($request->has('aspek')) {

            // Daftar Aspek (key = nomor aspek)
            $aspekList = [
                1 => 'Rencana Asesmen',
                2 => 'Interpretasi Standar Kompetensi',
                3 => 'Interpretasi Acuan Pembanding lainnya',
                4 => 'Proses Asesmen',
                5 => 'Penyeleksian dan Penerapan Metode Asesmen',
                6 => 'Penyeleksian dan Penerapan Perangkat Asesmen',
                7 => 'Bukti-bukti yang Dikumpulkan',
                8 => 'Pengambilan Keputusan'
            ];

            // Mapping checkbox kolom (posisi kolom -> huruf)
            $aturanMap  = [1 => 'V', 2 => 'A', 3 => 'T', 4 => 'M'];
            $prinsipMap = [5 => 'V', 6 => 'R', 7 => 'F1', 8 => 'F2'];

            // $request->input('aspek') sekarang ber-key sesuai nomor aspek (1..8)
            foreach ($request->input('aspek') as $no => $checks) {
                // pastikan $no adalah int
                $no = (int) $no;

                // Jika data bukan array skip
                if (!is_array($checks)) continue;

                $aturan  = [];
                $prinsip = [];

                foreach ($checks as $pos => $val) {
                    // checkbox yang dicentang biasanya bernilai "on"
                    if ($val) {
                        $pos = (int)$pos;

                        if (isset($aturanMap[$pos])) {
                            $aturan[] = $aturanMap[$pos];
                        }

                        if (isset($prinsipMap[$pos])) {
                            $prinsip[] = $prinsipMap[$pos];
                        }
                    }
                }

                // Siapkan data untuk insert
                $insertData = [
                    'id_validasi'     => $id_validasi,
                    'skema_id'        => $skema_id,
                    'user_id'         => auth()->id(),
                    'keterangan'      => null,
                    'keterampilan'    => null,
                    'aspek'           => $aspekList[$no] ?? null,
                    'aturan_bukti'    => !empty($aturan) ? implode(", ", $aturan) : null,
                    'prinsip_asesmen' => !empty($prinsip) ? implode(", ", $prinsip) : null,
                ];

                // Jika kamu ingin menyimpan baris khusus untuk "keterampilan komunikasi" misalnya,
                // maka jangan masukkan aspek 0 — kita sedang menyimpan aspek 1..8.
                // Jika perlu menyimpan keterampilan sebagai baris terpisah, lakukan di luar loop:
                DB::table('hasil_validasi')->insert($insertData);
            }

            // Jika ingin menyimpan keterampilan komunikasi sebagai baris terpisah di tabel hasil_validasi:
            if (!empty($skills)) {
                DB::table('hasil_validasi')->insert([
                    'id_validasi'     => $id_validasi,
                    'skema_id'        => $skema_id,
                    'user_id'         => auth()->id(),
                    'keterangan'      => 'Keterampilan Komunikasi',
                    'keterampilan'    => $keterampilanJson,
                    'aspek'           => null,
                    'aturan_bukti'    => null,
                    'prinsip_asesmen' => null,
                ]);
            }
        }

        return redirect()->route('form_perencanaan.fr_va_asesor', ['periode' => $nextPeriode, 'skema_id' => $skema_id])->with('success', "Data periode '{$nextPeriode}' berhasil disimpan!");
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
        
        // simpan fr_va_id di session
        session(['frva_id' => $frvaId]);        

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
        $periode = $request->periode ?? 'sebelum';

        // 0️⃣ Ambil atau buat id_validasi
        $validasi = DB::table('proses_validasi')
            ->where('skema_id', $skema_id)
            ->where('periode', $periode)
            ->first();

        if (!$validasi) {
            $validasiId = DB::table('proses_validasi')->insertGetId([
                'skema_id' => $skema_id,
                'periode' => $periode,
                'tujuan' => null,
                'konteks' => null,
                'pendekatan' => null,
            ]);
        } else {
            $validasiId = $validasi->id;
        }

        // 1️⃣ Simpan Kontribusi
        if ($request->temuan) {
            foreach ($request->temuan as $index => $temuan) {
                $temuan = trim($temuan);
                if (empty($temuan)) continue;

                $rekomendasi = $request->rekomendasi[$index] ?? '';
                DB::table('kontribusi')->insert([
                    'skema_id' => $skema_id,
                    'id_validasi' => $validasiId,
                    'temuan' => $temuan,
                    'rekomendasi' => $rekomendasi,
                ]);
            }
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
                    'id_validasi' => $validasiId,
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
            if (empty($nama)) continue;

            // pastikan tanggal tidak kosong
            if (empty($tanggal[$index])) {
                return back()->with('error', 'Tanggal validator wajib diisi!');
            }

            DB::table('validasi_validator')->insert([
                'skema_id' => $skema_id,
                'id_validasi' => $validasiId,
                'nama_validator' => $nama,
                'no_registrasi' => $no_registrasi[$index] ?? null,
                'tanggal' => $tanggal[$index],
                'ttd' => $ttd[$index] ?? null,
            ]);
        }

        return redirect()->route('formperencanaan.show', ['id_skema' => $skema_id])
                        ->with('success', 'Semua data berhasil disimpan!');
    }

    public function preview($skema_id, $periode)
{
    $skema = DB::table('skema_sertifikasi')
        ->where('id_skema', $skema_id)
        ->first();

    // Ambil validasi sesuai skema & periode
    $validasi = DB::table('proses_validasi')
        ->where('skema_id', $skema_id)
        ->where('periode', $periode)
        ->first();

    $validasiId = $validasi->id ?? null;

    // Checkbox master
    $allTujuan = [
        'Bagian dari Proses Penjaminan Mutu Organisasi',
        'Mengantisipasi Risiko',
        'Memenuhi Persyaratan BNSP',
        'Memastikan Kesesuaian Bukti',
        'Meningkatkan Kualitas Asesmen',
        'Mengevaluasi Kualitas Perangkat Asesmen'
    ];

    $allKonteks = [
        'Internal Organisasi',
        'Eksternal Organisasi',
        'Proses Lisensi / Re-Lisensi',
        'Dengan Kolega Asesor',
        'Kolega dari Organisasi Pelatihan atau Asesmen',
    ];

    $allPendekatan = [
        'Internal Organisasi',
        'Pertemuan Moderasi',
        'Mengkaji Perangkat Asesmen',
        'Acuan Pembanding',
        'Pengujian lapangan dan uji coba perangkat asesmen',
        'Umpan Balik dari Klien',
        'Mengkaji Bukti-bukti'
    ];

    // Data dari DB
    $tujuanSelected = $validasi && $validasi->tujuan ? explode(', ', $validasi->tujuan) : [];
    $pendekatanSelected = $validasi && $validasi->pendekatan ? explode(', ', $validasi->pendekatan) : [];
    $tujuanLainVal = $validasi->tujuan_lain ?? '';
    $konteksSelected = $validasi && $validasi->konteks 
        ? array_map('trim', explode(',', $validasi->konteks)) 
        : [];
    $konteksLainList = $validasi && $validasi->konteks_lain 
        ? json_decode($validasi->konteks_lain, true)
        : [];
    $allKonteksSelected = array_merge($konteksSelected, $konteksLainList);

    // Diskusi
    $diskusi = DB::table('diskusi')
        ->where('id_validasi', $validasiId)
        ->where('skema_id', $skema_id)
        ->get();

    // Orang relevan
    $orangRelevanData = [
        'asesorCheckbox' => false,
        'leadCheckbox' => false,
        'managerCheckbox' => false,
        'ahliCheckbox' => false,
        'koordinatorCheckbox' => false,
        'anggotaCheckbox' => false
    ];

    $jabatanMap = [
        'Asesor Kompetensi (wajib)' => 'asesorCheckbox',
        'Lead Asesor [Ketua TUK]' => 'leadCheckbox',
        'Manager, Supervisor' => 'managerCheckbox',
        'Tenaga Ahli di bidangnya' => 'ahliCheckbox',
        'Koordinator Pelatihan' => 'koordinatorCheckbox',
        'Anggota Asosiasi Industry Profesi' => 'anggotaCheckbox'
    ];

    foreach($diskusi as $item) {
        $key = $jabatanMap[$item->jabatan] ?? null;
        if($key) {
            $orangRelevanData[$key] = true;

            $names = array_map('trim', explode(',', $item->nama_asesor));
            foreach($names as $name) {
                $orangRelevanData[$key.'_detail'][] = [
                    'nama' => $name,
                    'diskusi' => $item->hasil_diskusi
                ];
            }
        }
    }

    $hasilDiskusi = $diskusi->pluck('hasil_diskusi')->unique()->implode("\n");

    // Ambil data acuan_pembanding
    $acuan = DB::table('acuan_pembanding')
        ->where('id_validasi', $validasiId)
        ->first();

    $acuanList = [
        'Standar Kompetensi (SKKNI/SKKK/SKI)',
        'Skema Sertifikasi',
        'SOP/IK',
        'Manual Instruction / Book Manual',
        'Standar Kinerja',
    ];

    $dokumenList = [
        'Perangkat Asesmen',
        'Peraturan / Pedoman',
        null,
        null,
        null,
    ];

    $acuanSelected = $acuan && $acuan->acuan
        ? array_map('trim', explode(',', $acuan->acuan))
        : [];

    $dokumenSelected = $acuan && $acuan->dokumen
        ? array_map('trim', explode(',', $acuan->dokumen))
        : [];

    $dokumenLain = [];
    if ($acuan && $acuan->dokumen_lain) {
        $decoded = json_decode($acuan->dokumen_lain, true);
        if (is_array($decoded)) {
            $dokumenLain = $decoded;
        } else {
            $dokumenLain = array_map('trim', explode(',', $acuan->dokumen_lain));
        }
    }
    for ($i = count($dokumenLain); $i < 4; $i++) $dokumenLain[$i] = '';
    $acuanLain = $acuan->acuan_lain ?? '';

    // ==========================================
    // Keterampilan Komunikasi
    // ==========================================
    $hasilValidasi = DB::table('hasil_validasi')
        ->where('id_validasi', $validasiId)
        ->where('skema_id', $skema_id)
        ->where('keterangan', 'Keterampilan Komunikasi')
        ->first();

    $selectedSkills = [];
    if ($hasilValidasi && $hasilValidasi->keterampilan) {
        $decoded = json_decode($hasilValidasi->keterampilan, true);
        if (is_array($decoded)) $selectedSkills = $decoded;
    }
    $skills = ['Pro Aktif','Active Listening','Empati'];

    // ==========================================
    // Aspek dalam Kegiatan
    // ==========================================
    $aspek = [
        'Rencana Asesmen',
        'Interpretasi Standar Kompetensi',
        'Interpretasi Acuan Pembanding lainnya',
        'Proses Asesmen',
        'Penyeleksian dan Penerapan Metode Asesmen',
        'Penyeleksian dan Penerapan Perangkat Asesmen',
        'Bukti-bukti yang Dikumpulkan',
        'Pengambilan Keputusan'
    ];

    $hasilAspek = DB::table('hasil_validasi')
        ->where('id_validasi', $validasiId)
        ->where('skema_id', $skema_id)
        ->whereIn('aspek', $aspek)
        ->get();

    $aspekData = [];
    $aturanMap = ['V'=>1,'A'=>2,'T'=>3,'M'=>4];
    $prinsipMap = ['V'=>5,'R'=>6,'F1'=>7,'F2'=>8];
    foreach($aspek as $i => $item) {
        $aspekData[$i] = [];
        $row = $hasilAspek->firstWhere('aspek', $item);
        if($row) {
            // aturan bukti
            if($row->aturan_bukti) {
                $vals = explode(',', $row->aturan_bukti);
                foreach($vals as $v) {
                    $v = trim($v);
                    if(isset($aturanMap[$v])) {
                        $aspekData[$i][$aturanMap[$v]] = true;
                    }
                }
            }

            // prinsip asesmen
            if($row->prinsip_asesmen) {
                $vals = explode(',', $row->prinsip_asesmen);
                $fCount = 0;
                foreach($vals as $v) {
                    $v = trim($v);
                    if($v == 'F') {
                        $fCount++;
                        $v = 'F'.$fCount;
                    }
                    if(isset($prinsipMap[$v])) {
                        $aspekData[$i][$prinsipMap[$v]] = true;
                    }
                }
            }
        }
    }

    // ==========================================
    // Temuan & Rekomendasi per skema & periode
    // ==========================================
    $kontribusiList = DB::table('kontribusi')
        ->join('proses_validasi', 'kontribusi.id_validasi', '=', 'proses_validasi.id')
        ->where('proses_validasi.skema_id', $skema_id)
        ->where('proses_validasi.periode', $periode)
        ->select('kontribusi.*')
        ->get();

    $temuan = [];
    $rekomendasi = [];
    foreach($kontribusiList as $kontribusi) {
        if($kontribusi->temuan) {
            $temuan = array_merge($temuan, array_map('trim', explode(',', $kontribusi->temuan)));
        }
        if($kontribusi->rekomendasi) {
            $rekomendasi = array_merge($rekomendasi, array_map('trim', explode(',', $kontribusi->rekomendasi)));
        }
    }

    // ==========================================
    // Rencana Perbaikan per skema & periode
    // ==========================================
    $perbaikanData = DB::table('rencana_perbaikan')
        ->join('proses_validasi', 'rencana_perbaikan.id_validasi', '=', 'proses_validasi.id')
        ->where('proses_validasi.skema_id', $skema_id)
        ->where('proses_validasi.periode', $periode)
        ->select('rencana_perbaikan.*')
        ->get();

    $perbaikan = [];
    $waktuPerbaikan = [];
    $penanggungPerbaikan = [];
    $ttdPerbaikan = [];
    foreach($perbaikanData as $p) {
        $perbaikan[] = $p->kegiatan_perbaikan;
        $waktuPerbaikan[] = $p->waktu_penyelesaian;
        $penanggungPerbaikan[] = $p->penanggung_jawab;
        $ttdPerbaikan[] = $p->ttd;
    }

    // ==========================================
    // Validator per skema & periode
    // ==========================================
    $validatorData = DB::table('validasi_validator')
        ->join('proses_validasi', 'validasi_validator.id_validasi', '=', 'proses_validasi.id')
        ->where('proses_validasi.skema_id', $skema_id)
        ->where('proses_validasi.periode', $periode)
        ->select('validasi_validator.*')
        ->get();

    $validator = [];
    $noMet = [];
    $tanggal = [];
    $ttdValidator = [];
    foreach($validatorData as $v) {
        $validator[] = $v->nama_validator;
        $noMet[] = $v->no_registrasi;
        $tanggal[] = $v->tanggal;
        $ttdValidator[] = $v->ttd;
    }

    // ==========================================
    // Periode user-friendly
    // ==========================================
    $periodeText = match($periode) {
        'sebelum' => 'Sebelum Asesmen',
        'saat'    => 'Saat Asesmen',
        'sesudah' => 'Sesudah Asesmen',
        default   => 'Periode Tidak Diketahui',
    };

    return view('form_perencanaan.fr_va.fr_va_pdf', [
        'skema' => $skema,
        'validasi' => $validasi,
        'allTujuan' => $allTujuan,
        'allKonteks' => $allKonteks,
        'allPendekatan' => $allPendekatan,
        'tujuanSelected' => $tujuanSelected,
        'konteksSelected' => $konteksSelected,
        'pendekatanSelected' => $pendekatanSelected,
        'tujuanLainVal' => $tujuanLainVal,
        'konteksLainList' => $konteksLainList,
        'diskusi' => $diskusi,
        'hasilDiskusi' => $hasilDiskusi,
        'orangRelevanData' => $orangRelevanData,
        'acuanList' => $acuanList,
        'dokumenList' => $dokumenList,
        'acuanSelected' => $acuanSelected,
        'dokumenSelected' => $dokumenSelected,
        'dokumenLain' => $dokumenLain,
        'acuanLain' => $acuanLain,
        'selectedSkills' => $selectedSkills,
        'skills' => $skills,
        'aspek' => $aspek,
        'aspekData' => $aspekData,
        'temuan' => $temuan,
        'rekomendasi' => $rekomendasi,
        'perbaikan' => $perbaikan,
        'waktuPerbaikan' => $waktuPerbaikan,
        'penanggungPerbaikan' => $penanggungPerbaikan,
        'ttdPerbaikan' => $ttdPerbaikan,
        'validator' => $validator,
        'noMet' => $noMet,
        'tanggal' => $tanggal,
        'ttdValidator' => $ttdValidator,
        'periode' => $periode,
        'periodeText' => $periodeText,
        'allKonteksSelected' => $allKonteksSelected,
    ]);
}

public function download($skema_id, $periode)
{
    // =============================
    // 0. VALIDASI PERIODE
    // =============================
    $periodeText = [
        'sebelum' => 'Sebelum Asesmen',
        'saat'    => 'Saat Asesmen',
        'sesudah' => 'Sesudah Asesmen'
    ];

    // =============================
    // 1. AMBIL DATA SKEMA
    // =============================
    $skema = DB::table('skema_sertifikasi')
        ->where('id_skema', $skema_id)
        ->first();

    // =============================
    // 2. AMBIL ID VALIDASI
    // =============================
    $prosesValidasi = DB::table('proses_validasi')
        ->where('skema_id', $skema_id)
        ->where('periode', $periode)
        ->first();

    $validasiId = $prosesValidasi->id ?? null;


    // =============================
    // 3. VALIDATOR
    // =============================
    $validators = DB::table('validasi_validator')
        ->where('id_validasi', $validasiId)
        ->select('nama_validator as nama_asesor', 'tanggal', 'ttd')
        ->get();


    // =============================
    // 4. MASTER LIST
    // =============================
    $allTujuan = [
        'Bagian dari Proses Penjaminan Mutu Organisasi',
        'Mengantisipasi Risiko',
        'Memenuhi Persyaratan BNSP',
        'Memastikan Kesesuaian Bukti',
        'Meningkatkan Kualitas Asesmen',
        'Mengevaluasi Kualitas Perangkat Asesmen'
    ];

    $allKonteks = [
        'Internal Organisasi',
        'Eksternal Organisasi',
        'Proses Lisensi / Re-Lisensi',
        'Dengan Kolega Asesor',
        'Kolega dari Organisasi Pelatihan atau Asesmen',
    ];

    $allPendekatan = [
        'Panel Asesmen',
        'Pertemuan Moderasi',
        'Mengkaji Perangkat Asesmen',
        'Acuan Pembanding',
        'Pengujian lapangan dan uji coba perangkat asesmen',
        'Umpan Balik dari Klien',
        'Mengkaji Bukti-bukti'
    ];


    // =============================
    // 5. CEKLIS DARI DB
    // =============================
    $tujuanSelected     = $prosesValidasi->tujuan ? array_map('trim', explode(',', $prosesValidasi->tujuan)) : [];
    $allKonteksSelected = $prosesValidasi->konteks ? array_map('trim', explode(',', $prosesValidasi->konteks)) : [];
    $pendekatanSelected = $prosesValidasi->pendekatan ? array_map('trim', explode(',', $prosesValidasi->pendekatan)) : [];

    // =============================
    // 6. TUJUAN LAIN / KONTEKS LAIN
    // =============================
    $tujuanLainVal   = trim($prosesValidasi->tujuan_lain ?? '');
    $konteksLainRaw  = trim($prosesValidasi->konteks_lain ?? '');
    $konteksLainList = [];

    if ($konteksLainRaw) {
        $tmp = array_map('trim', explode(',', $konteksLainRaw));
        foreach ($tmp as $item) {
            $item = trim($item, '[]"');
            if ($item !== '') {
                $konteksLainList[] = $item;
            }
        }
    }


    // =============================
    // 7. HASIL DISKUSI
    // =============================
    $hasilDiskusi = DB::table('diskusi')
        ->where('id_validasi', $validasiId)
        ->get();

    $jabatanList = [
        'Asesor Kompetensi (wajib)',
        'Lead Asesor [Ketua TUK]',
        'Manager, Supervisor',
        'Tenaga Ahli di bidangnya',
        'Koordinator Pelatihan',
        'Anggota Asosiasi Industry Profesi'
    ];

    $orangRelevanTable = [];

    foreach ($jabatanList as $jabatan) {
        $asesors = $hasilDiskusi->where('jabatan', $jabatan);
        $namaList = [];

        foreach ($asesors as $a) {
            $namaList = array_merge($namaList, array_map('trim', explode(',', $a->nama_asesor)));
        }

        $orangRelevanTable[] = [
            'jabatan' => $jabatan,
            'adaIsi' => count($namaList) > 0,
            'namaList' => $namaList
        ];
    }

    $hasilDiskusiGlobal = $hasilDiskusi->pluck('hasil_diskusi')->filter()->implode("\n");


    // =============================
    // 8. ACUAN PEMBANDING
    // =============================
    $acuanDb = DB::table('acuan_pembanding')
        ->where('id_validasi', $validasiId)
        ->first();

    $defaultAcuan = [
        'Standar Kompetensi (SKKNI/SKKK/SKI)',
        'Skema Sertifikasi',
        'SOP/IK',
        'Manual Instruction / Book Manual',
        'Standar Kinerja'
    ];

    $defaultDokumen = [
        'Perangkat Asesmen',
        'Peraturan / Pedoman'
    ];

    $acuanTambahan = $acuanDb && $acuanDb->acuan_lain
        ? array_filter(array_map('trim', explode(',', $acuanDb->acuan_lain)))
        : [];

    $dokumenTambahan = $acuanDb && $acuanDb->dokumen_lain
        ? array_filter(array_map('trim', explode(',', $acuanDb->dokumen_lain)))
        : [];

    $acuanSelected = $acuanDb && $acuanDb->acuan
        ? array_map('trim', explode(',', $acuanDb->acuan))
        : [];

    $dokumenSelected = $acuanDb && $acuanDb->dokumen
        ? array_map('trim', explode(',', $acuanDb->dokumen))
        : [];


    // =============================
    // 9. KETERAMPILAN KOMUNIKASI
    // =============================
    $defaultKeterampilan = ['pro aktif', 'active listening', 'empati'];

    $hasilKeterampilan = DB::table('hasil_validasi')
        ->where('id_validasi', $validasiId)
        ->where('skema_id', $skema_id)
        ->where('keterangan', 'LIKE', '%Keterampilan%')
        ->first();

    $keterampilanSelected = [];

    if ($hasilKeterampilan && $hasilKeterampilan->keterampilan) {
        $decoded = json_decode($hasilKeterampilan->keterampilan, true);
        if (is_array($decoded)) {
            $keterampilanSelected = array_map('strtolower', $decoded);
        }
    }


    // =============================
    // 10. ATURAN & PRINSIP ASESMENT
    // =============================
    $aturanList  = ['V', 'A', 'T', 'M'];
    $prinsipList = ['V', 'R', 'F1', 'F2'];
    $prinsipHeaderPdf = ['V','R','F','F'];

    $aspekLabels = [
        'Rencana Asesmen',
        'Interpretasi Standar Kompetensi',
        'Interpretasi Acuan Pembanding lainnya',
        'Proses Asesmen',
        'Penyeleksian dan Penerapan Metode Asesmen',
        'Penyeleksian dan Penerapan Perangkat Asesmen',
        'Bukti-bukti yang Dikumpulkan',
        'Pengambilan Keputusan'
    ];

    $dataAspek = DB::table('hasil_validasi')
        ->where('id_validasi', $validasiId)
        ->where('skema_id', $skema_id)
        ->whereNotNull('aspek')
        ->get();

    $aspekList = [];

    foreach ($aspekLabels as $i => $label) {
        $row = $dataAspek->firstWhere('aspek', $label);

        $aturan = $row && $row->aturan_bukti
            ? array_map('trim', explode(',', $row->aturan_bukti))
            : [];

        $prinsip = $row && $row->prinsip_asesmen
            ? array_map('trim', explode(',', $row->prinsip_asesmen))
            : [];

        $aspekList[] = [
            'no'      => $i + 1,
            'label'   => $label,
            'aturan'  => $aturan,
            'prinsip' => $prinsip,
        ];
    }

        $redCells = [];

        // Data Temuan & Rekomendasi
        $kontribusiList = DB::table('kontribusi')
        ->join('proses_validasi', 'kontribusi.id_validasi', '=', 'proses_validasi.id')
        ->where('proses_validasi.skema_id', $skema_id)
        ->where('proses_validasi.periode', $periode)
        ->select('kontribusi.*')
        ->get();

        // Siapkan array gabungan kalau perlu
        $temuan = [];
        $rekomendasi = [];
        foreach ($kontribusiList as $kontribusi) {
        if ($kontribusi->temuan) {
            // Misal temuan dipisah koma
            $temuan = array_merge($temuan, array_map('trim', explode(',', $kontribusi->temuan)));
        }
        if ($kontribusi->rekomendasi) {
            $rekomendasi = array_merge($rekomendasi, array_map('trim', explode(',', $kontribusi->rekomendasi)));
        }
    }

// ==========================================
// Rencana Perbaikan per skema & periode
// ==========================================
$rencanaList = DB::table('rencana_perbaikan')
    ->join('proses_validasi', 'rencana_perbaikan.id_validasi', '=', 'proses_validasi.id')
    ->where('proses_validasi.skema_id', $skema_id)
    ->where('proses_validasi.periode', $periode)
    ->select('rencana_perbaikan.*')
    ->get();

// Optional: kalau mau buat array terpisah
$perbaikan = [];
$waktuPerbaikan = [];
$penanggungPerbaikan = [];
$ttdPerbaikan = [];

foreach ($rencanaList as $p) {
    $perbaikan[] = $p->kegiatan_perbaikan;
    $waktuPerbaikan[] = $p->waktu_penyelesaian;
    $penanggungPerbaikan[] = $p->penanggung_jawab;
    $ttdPerbaikan[] = $p->ttd;
}

    // =============================
    // 11. GENERATE PDF
    // =============================
    $pdf = Pdf::loadView('form_perencanaan.fr_va.pdf_frva', [
        'skema'        => $skema,
        'periode'      => $periode,
        'periodeText'  => $periodeText[$periode] ?? $periode,

        'validators' => $validators,

        'allTujuan'          => $allTujuan,
        'allKonteks'         => $allKonteks,
        'allPendekatan'      => $allPendekatan,
        'tujuanSelected'     => $tujuanSelected,
        'allKonteksSelected' => $allKonteksSelected,
        'pendekatanSelected' => $pendekatanSelected,

        'tujuanLainVal'   => $tujuanLainVal,
        'konteksLainRaw'  => $konteksLainRaw,
        'konteksLainList' => $konteksLainList,

        'orangRelevanTable'  => $orangRelevanTable,
        'hasilDiskusiGlobal' => $hasilDiskusiGlobal,

        'defaultAcuan'    => $defaultAcuan,
        'defaultDokumen'  => $defaultDokumen,
        'acuanLain'       => $acuanTambahan,
        'dokumenLain'     => $dokumenTambahan,
        'acuanSelected'   => $acuanSelected,
        'dokumenSelected' => $dokumenSelected,

        'defaultKeterampilan'  => $defaultKeterampilan,
        'keterampilanSelected' => $keterampilanSelected,

        'aspekList'  => $aspekList,
        'aturanList' => $aturanList,
        'prinsipList'=> $prinsipList,
        'prinsipHeaderPdf' => $prinsipHeaderPdf,
        'redCells'   => $redCells,

        'kontribusiList' => $kontribusiList,
        'temuan'         => $temuan,
        'rekomendasi'    => $rekomendasi,

        'rencanaList'      => $rencanaList,
        'perbaikan'        => $perbaikan,
        'waktuPerbaikan'   => $waktuPerbaikan,
        'penanggungPerbaikan'=> $penanggungPerbaikan,
        'ttdPerbaikan'     => $ttdPerbaikan,
    ])
    ->setPaper('A4', 'portrait');

    return $pdf->download("FR_VA_{$skema->kode_skema}_{$periode}.pdf");
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
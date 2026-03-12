<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pertanyaan;
use App\Models\JawabanAsesmen;
use App\Models\Asesi;
use App\Models\Asesor;
use App\Models\PembuatanPertanyaan;

class JawabanController extends Controller
{
    /**
     * Tampilkan daftar pertanyaan sesuai skema & jenis soal
     */

     public function index()
     {
         $user = auth()->user();
         if (!$user) {
             return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
         }
     
         // Ambil data asesi login
         $asesi = Asesi::where('user_id', $user->id)->first();
         if (!$asesi) {
             return redirect()->route('login')->withErrors(['error' => 'Data Asesi tidak ditemukan.']);
         }
     
         // Ambil semua skema yang terhubung dengan asesor dari asesi ini
         $skemaList = DB::table('asesor_skema')
             ->join('skema_sertifikasi', 'asesor_skema.skema_id', '=', 'skema_sertifikasi.id_skema')
             ->where('asesor_skema.asesor_id', $asesi->asesor_id)
             ->select(
                 'skema_sertifikasi.id_skema',
                 'skema_sertifikasi.nama_skema',
                 'skema_sertifikasi.kode_skema',
                 'skema_sertifikasi.status_skema'
             )
             ->orderBy('skema_sertifikasi.nama_skema')
             ->get();
     
         // Ambil status penyelesaian asesmen untuk setiap skema dan jenis
         $statusAsesmen = [];
     
         foreach ($skemaList as $skema) {
             // Hitung jumlah pertanyaan per jenis untuk skema ini
             $jumlahPertanyaan = [
                 'pilihan_ganda' => DB::table('pertanyaan')
                     ->where('id_skema', $skema->id_skema)
                     ->where('jenis_pertanyaan', 'pilihan_ganda')
                     ->count(),
                 'esai' => DB::table('pertanyaan')
                     ->where('id_skema', $skema->id_skema)
                     ->where('jenis_pertanyaan', 'esai')
                     ->count(),
                 'lisan' => DB::table('pertanyaan')
                     ->where('id_skema', $skema->id_skema)
                     ->where('jenis_pertanyaan', 'lisan')
                     ->count(),
             ];
     
             // Hitung jumlah jawaban per jenis untuk asesi dan skema ini
             $jumlahJawaban = [
                 'pilihan_ganda' => DB::table('jawaban_asesmen')
                     ->join('pertanyaan', 'jawaban_asesmen.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                     ->where('jawaban_asesmen.id_asesi', $asesi->id_asesi)
                     ->where('jawaban_asesmen.id_skema', $skema->id_skema)
                     ->where('pertanyaan.jenis_pertanyaan', 'pilihan_ganda')
                     ->count(),
                 'esai' => DB::table('jawaban_asesmen')
                     ->join('pertanyaan', 'jawaban_asesmen.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                     ->where('jawaban_asesmen.id_asesi', $asesi->id_asesi)
                     ->where('jawaban_asesmen.id_skema', $skema->id_skema)
                     ->where('pertanyaan.jenis_pertanyaan', 'esai')
                     ->count(),
                 'lisan' => DB::table('jawaban_asesmen')
                     ->join('pertanyaan', 'jawaban_asesmen.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                     ->where('jawaban_asesmen.id_asesi', $asesi->id_asesi)
                     ->where('jawaban_asesmen.id_skema', $skema->id_skema)
                     ->where('pertanyaan.jenis_pertanyaan', 'lisan')
                     ->count(),
             ];
     
             // Tentukan status dasar
             $statusLisanDasar = $jumlahJawaban['lisan'] >= $jumlahPertanyaan['lisan'] && $jumlahPertanyaan['lisan'] > 0;
     
             // 🔹 Tambahkan logika cek tanda tangan lisan (jika sudah ada di tabel persetujuan)
             $sudahTtdLisan = false;
             if ($statusLisanDasar) {
                 $sudahTtdLisan = DB::table('jawaban_asesmen_persetujuan')
                     ->join('jawaban_asesmen', 'jawaban_asesmen_persetujuan.id_jawaban', '=', 'jawaban_asesmen.id_jawaban')
                     ->join('pertanyaan', 'jawaban_asesmen.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                     ->where('jawaban_asesmen.id_asesi', $asesi->id_asesi)
                     ->where('jawaban_asesmen.id_skema', $skema->id_skema)
                     ->where('pertanyaan.jenis_pertanyaan', 'lisan')
                     ->exists();
             }
     
             // Simpan status ke array
             $statusAsesmen[$skema->id_skema] = [
                 'pilihan_ganda' => $jumlahJawaban['pilihan_ganda'] >= $jumlahPertanyaan['pilihan_ganda'] && $jumlahPertanyaan['pilihan_ganda'] > 0,
                 'esai' => $jumlahJawaban['esai'] >= $jumlahPertanyaan['esai'] && $jumlahPertanyaan['esai'] > 0,
                 'lisan' => $statusLisanDasar,
                 'ttd_lisan_selesai' => $sudahTtdLisan, // tambahan untuk view
             ];
         }
     
         return view('pilih_asesmen', compact('asesi', 'skemaList', 'statusAsesmen'));
     }
     

    public function show($id_skema, $jenis)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }
    
        $asesi = Asesi::where('user_id', $user->id)->first();
        if (!$asesi) {
            return redirect()->route('login')->withErrors(['error' => 'Data Asesi tidak ditemukan.']);
        }
        $id_asesi = $asesi->id_asesi;
    
        // mapping alias URL ke nilai DB
        $mapJenis = [
            'pg' => 'pilihan_ganda',
            'pilihan_ganda' => 'pilihan_ganda',
            'esai' => 'esai',
            'lisan' => 'lisan',
        ];
        if (!isset($mapJenis[$jenis])) {
            abort(404, 'Jenis pertanyaan tidak valid');
        }
        $jenisDb = $mapJenis[$jenis];
    
        // ambil pertanyaan lengkap dengan id_pembuatan_pertanyaan
        $pertanyaan = Pertanyaan::where('id_skema', $id_skema)
            ->where('jenis_pertanyaan', $jenisDb)
            ->with(['opsiJawaban' => fn($q) => $q->orderBy('kode_opsi')])
            ->get();
    
        if ($pertanyaan->isEmpty()) {
            return view("jawaban.$jenisDb" , compact(
                'pertanyaan',
                'id_skema',
                'asesi',
                'id_asesi'
            ));
        }
    
        // ambil jawaban lama user
        $jawabanRaw = JawabanAsesmen::where('id_asesi', $id_asesi)
            ->where('id_skema', $id_skema)
            ->get();
    
        $jawaban = [];
        foreach ($jawabanRaw as $j) {
            $jawaban[$j->id_pertanyaan] = $j->jawaban_opsi ?? $j->jawaban_text;
        }

        $skema = DB::table('skema_sertifikasi')->where('id_skema', $id_skema)->first();
    
        // kumpulkan semua id_pembuatan_pertanyaan dari pertanyaan
        $idsPembuatan = $pertanyaan->pluck('id_pembuatan_pertanyaan')->unique();
    
        // ambil semua pembuatan pertanyaan terkait
        $pembuatanList = PembuatanPertanyaan::whereIn('id_pembuatan_pertanyaan', $idsPembuatan)->get();
    
        // ambil 1 pembuatan pertanyaan
        $pembuatan = $pembuatanList->first();
        $id_pembuatan_pertanyaan = $pembuatan?->id_pembuatan_pertanyaan;
        $timer = $pembuatan?->timer ?? 0; // menit
        $timescap = $pembuatan?->timescap;
    
        // hitung sisa waktu (dalam detik)
        $sisaDetik = $timer * 60;
        if ($timescap) {
            $endTime = \Carbon\Carbon::parse($timescap)->addMinutes($timer);
            $sisaDetik = now()->diffInSeconds($endTime, false);
            if ($sisaDetik < 0) {
                $sisaDetik = 0; // sudah habis
            }
        }
    
        // pilih view
        $viewMap = [
            'pilihan_ganda' => 'jawaban.pg_asesi',
            'esai' => 'jawaban.esai_asesi',
            'lisan' => 'jawaban.lisan_asesi',
        ];
    
        return view($viewMap[$jenisDb], compact(
            'pertanyaan',
            'jawaban',
            'id_skema',
            'timer',
            'timescap',
            'asesi',
            'id_asesi',
            'id_pembuatan_pertanyaan',
            'sisaDetik',
            'skema'
        ));
    }

    /**
     * Simpan atau update jawaban user
     */
    public function store(Request $request)
    {
        // 🔹 Validasi awal
        $request->validate([
            'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
            'jenis'    => 'required|in:lisan,esai,pilihan_ganda',
            'jawaban'  => 'nullable|array',
        ]);
    
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }
    
        $asesi = Asesi::where('user_id', $user->id)->first();
        if (!$asesi) {
            return redirect()->route('login')->withErrors(['error' => 'Data Asesi tidak ditemukan. Hubungi admin.']);
        }
    
        $idAsesi = $asesi->id_asesi;
        $jawabanList = $request->jawaban ?? []; // kalau null, ubah jadi array kosong
    
        // 🔹 Jalankan transaksi
        \DB::transaction(function() use ($request, $idAsesi, $asesi, $jawabanList) {
    
            // ✅ Ambil semua id pertanyaan (agar semua pertanyaan tercatat meskipun tidak dijawab)
            $pertanyaanSemua = \DB::table('pertanyaan')
                ->where('id_skema', $request->id_skema)
                ->where('jenis_pertanyaan', $request->jenis)
                ->pluck('id_pertanyaan');
    
                foreach ($pertanyaanSemua as $id_pertanyaan) {
                    $text = $jawabanList[$id_pertanyaan] ?? null;
                
                    if ($request->jenis === 'pilihan_ganda') {
                        // Ambil id_opsi yang benar dari tabel opsi_jawaban
                        $idOpsiKunci = \DB::table('opsi_jawaban')
                            ->where('id_pertanyaan', $id_pertanyaan)
                            ->where('benar', 1)
                            ->value('id_opsi');
                
                        $jawabanUserId = $text ? intval($text) : null;
                
                        $pencapaian = 0;
                        if (!empty($jawabanUserId) && $idOpsiKunci) {
                            $pencapaian = ($idOpsiKunci === $jawabanUserId) ? 1 : 0;
                        }
                
                        JawabanAsesmen::updateOrCreate(
                            [
                                'id_asesi'      => $idAsesi,
                                'id_skema'      => $request->id_skema,
                                'id_pertanyaan' => $id_pertanyaan
                            ],
                            [
                                'jawaban_opsi'  => $jawabanUserId,
                                'jawaban_text'  => null,
                                'pencapaian'    => $pencapaian,
                            ]
                        );
                    } else {
                        // Untuk esai atau lisan → pencapaian = null
                        JawabanAsesmen::updateOrCreate(
                            [
                                'id_asesi'      => $idAsesi,
                                'id_skema'      => $request->id_skema,
                                'id_pertanyaan' => $id_pertanyaan
                            ],
                            [
                                'jawaban_opsi'  => null,
                                'jawaban_text'  => $text ?: null,
                                'pencapaian'    => null,
                            ]
                        );
                    }
                }
                
    
            // 🔹 Simpan tanda tangan (jika ada dan valid)
            if ($request->filled('ttd_asesi')) {
                $ttdBase64 = $request->ttd_asesi;
    
                if (preg_match('/^data:image\/(\w+);base64,/', $ttdBase64)) {
                    $ttdData = preg_replace('#^data:image/\w+;base64,#i', '', $ttdBase64);
                    $ttdData = str_replace(' ', '+', $ttdData);
                    $imageData = base64_decode($ttdData);
    
                    if ($imageData !== false) {
                        $jenis = $request->jenis;
                        $namaAsesi = \Str::slug($asesi->nama_lengkap, '_');
                        $tanggal = $request->tgl_ttd_asesi ?: date('Y-m-d');
                        $fileName = 'ttd_asesmen_' . $namaAsesi . '_' . $jenis . '_' . $tanggal . '.png';
                        $filePath = storage_path('app/public/ttd/' . $fileName);
    
                        if (!file_exists(dirname($filePath))) {
                            mkdir(dirname($filePath), 0755, true);
                        }
    
                        file_put_contents($filePath, $imageData);
    
                        // Ambil jawaban terakhir KHUSUS untuk jenis soal ini
                        $lastJawaban = JawabanAsesmen::where('id_asesi', $idAsesi)
                            ->where('id_skema', $request->id_skema)
                            ->whereHas('pertanyaan', function($q) use ($request) {
                                $q->where('jenis_pertanyaan', $request->jenis);
                            })
                            ->orderBy('id_jawaban', 'desc')
                            ->first();
    
                        if ($lastJawaban) {
                            $existingPersetujuan = \DB::table('jawaban_asesmen_persetujuan')
                                ->where('id_jawaban', $lastJawaban->id_jawaban)
                                ->exists();
    
                            if (!$existingPersetujuan) {
                                \DB::table('jawaban_asesmen_persetujuan')->insert([
                                    'id_jawaban'    => $lastJawaban->id_jawaban,
                                    'tgl_ttd_asesi' => $tanggal,
                                    'ttd_asesi'     => 'storage/ttd/' . $fileName,
                                    'created_at'    => now(),
                                    'updated_at'    => now(),
                                ]);
                            }
                        }
                    }
                }
            }
        });
    
        // 🔹 Jika dikirim via AJAX
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
    
        // 🔹 Redirect jika non-AJAX
        return redirect()->route('asesmen.pilih')->with('success', 'Jawaban berhasil disimpan!');
    }
    
 
    public function ttdLisan($idSkema)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }
    
        $asesi = Asesi::where('user_id', $user->id)->first();
        if (!$asesi) {
            return redirect()->route('login')->withErrors(['error' => 'Data Asesi tidak ditemukan.']);
        }
    
        $skema = DB::table('skema_sertifikasi')->where('id_skema', $idSkema)->first();
        if (!$skema) {
            return redirect()->back()->withErrors(['error' => 'Skema tidak ditemukan.']);
        }
    
        try {
            // Jumlah soal lisan untuk skema ini
            $jumlahPertanyaanLisan = DB::table('pertanyaan')
                ->where('id_skema', $idSkema)
                ->where('jenis_pertanyaan', 'lisan')
                ->count();
    
            // Kalau tidak ada soal lisan, beri tahu dan jangan lanjut ke form ttd
            if ($jumlahPertanyaanLisan <= 0) {
                return redirect()->back()->withErrors(['error' => 'Tidak ada soal asesmen lisan pada skema ini.']);
            }
    
            // Hitung jumlah pertanyaan lisan yang sudah memiliki baris jawaban oleh asesi ini.
            // NOTE: kita tidak memakai whereNotNull karena baris bisa sudah dibuat dengan jawaban null.
            $jumlahJawabanLisan = DB::table('jawaban_asesmen')
                ->join('pertanyaan', 'jawaban_asesmen.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
                ->where('jawaban_asesmen.id_asesi', $asesi->id_asesi)
                ->where('jawaban_asesmen.id_skema', $idSkema)
                ->where('pertanyaan.jenis_pertanyaan', 'lisan')
                ->distinct('jawaban_asesmen.id_pertanyaan')
                ->count('jawaban_asesmen.id_pertanyaan');
    
            if ($jumlahJawabanLisan < $jumlahPertanyaanLisan) {
                return redirect()->back()->withErrors(['error' => 'Kamu belum menjawab semua soal asesmen lisan.']);
            }
    
            // Semua OK — tampilkan form tanda tangan
            return view('jawaban.lisan_ttd', compact('skema', 'asesi'));
        } catch (\Exception $e) {
            // Tangkap error DB / lain-lain agar tidak menampilkan stacktrace ke user
            \Log::error('Error ttdLisan: ' . $e->getMessage(), [
                'idSkema' => $idSkema,
                'user_id' => $user->id ?? null,
            ]);
    
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memeriksa status jawaban. Silakan coba lagi atau hubungi admin.']);
        }
    }    

    //asesor
    protected function getAsesor()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login.']);
        }

        $asesor = Asesor::where('user_id', $user->id)->first();
        if (!$asesor) {
            abort(403, 'Anda bukan asesor.');
        }
        return $asesor;
    }

    /**
     * Tampilkan daftar skema yang dimiliki asesor.
     */
    public function indexSkema()
    {
        $asesor = $this->getAsesor();

        $skemaList = DB::table('asesor_skema')
            ->join('skema_sertifikasi', 'asesor_skema.skema_id', '=', 'skema_sertifikasi.id_skema')
            ->where('asesor_skema.asesor_id', $asesor->id_asesor)
            ->select('skema_sertifikasi.id_skema', 'skema_sertifikasi.nama_skema', 'skema_sertifikasi.kode_skema')
            ->orderBy('skema_sertifikasi.nama_skema')
            ->get();

        return view('asesor.skema_index', compact('skemaList'));
    }

    /**
     * Tampilkan pilihan jenis pertanyaan untuk skema tertentu.
     */
    public function listJenis($id_skema)
    {
        $asesor = $this->getAsesor();

        // Pastikan skema ini milik asesor
        $skema = DB::table('asesor_skema')
            ->join('skema_sertifikasi', 'asesor_skema.skema_id', '=', 'skema_sertifikasi.id_skema')
            ->where('asesor_skema.asesor_id', $asesor->id_asesor)
            ->where('skema_sertifikasi.id_skema', $id_skema)
            ->select('skema_sertifikasi.id_skema', 'skema_sertifikasi.nama_skema')
            ->first();

        if (!$skema) {
            abort(404, 'Skema tidak ditemukan atau bukan milik Anda.');
        }

        return view('asesor.jenis_index', compact('skema'));
    }

    /**
     * Tampilkan daftar asesi yang telah mengerjakan (atau terdaftar) untuk skema & jenis tertentu.
     */
    public function listAsesi($id_skema, $jenis)
    {
        $asesor = $this->getAsesor();

        // Mapping jenis dari URL ke nilai DB
        $mapJenis = [
            'pg' => 'pilihan_ganda',
            'pilihan_ganda' => 'pilihan_ganda',
            'esai' => 'esai',
            'lisan' => 'lisan',
        ];
        if (!isset($mapJenis[$jenis])) {
            abort(404, 'Jenis pertanyaan tidak valid');
        }
        $jenisDb = $mapJenis[$jenis];

        // Ambil semua asesi yang berada di bawah asesor ini
        $asesiList = Asesi::where('asesor_id', $asesor->id_asesor)->get();

        // Untuk setiap asesi, hitung status pengerjaan jenis soal ini
        $dataAsesi = [];
        foreach ($asesiList as $asesi) {
            $jumlahPertanyaan = Pertanyaan::where('id_skema', $id_skema)
                ->where('jenis_pertanyaan', $jenisDb)
                ->count();

                $jumlahJawaban = JawabanAsesmen::where('id_asesi', $asesi->id_asesi)
                ->where('id_skema', $id_skema)
                ->whereHas('pertanyaan', function ($q) use ($jenisDb) {
                    $q->where('jenis_pertanyaan', $jenisDb);
                })
                ->where(function ($q) {
                    $q->whereNotNull('jawaban_opsi')
                      ->orWhereNotNull('jawaban_text');
                })
                ->count();

                $status = ($jumlahJawaban > 0) ? 'selesai' : 'belum';

            $dataAsesi[] = [
                'id_asesi' => $asesi->id_asesi,
                'nama' => $asesi->nama_lengkap,
                'status' => $status,
                'jumlah_pertanyaan' => $jumlahPertanyaan,
                'jumlah_jawaban' => $jumlahJawaban,
            ];
        }

        $skema = DB::table('skema_sertifikasi')->where('id_skema', $id_skema)->first(['nama_skema']);

        return view('asesor.asesi_list', compact('dataAsesi', 'id_skema', 'jenis', 'skema', 'jenisDb'));
    }

    /**
     * Tampilkan jawaban seorang asesi untuk skema & jenis tertentu.
     */
    public function viewJawaban($id_skema, $jenis, $id_asesi)
    {
        $asesor = $this->getAsesor();

        // Mapping jenis
        $mapJenis = [
            'pg' => 'pilihan_ganda',
            'pilihan_ganda' => 'pilihan_ganda',
            'esai' => 'esai',
            'lisan' => 'lisan',
        ];
        if (!isset($mapJenis[$jenis])) {
            abort(404);
        }
        $jenisDb = $mapJenis[$jenis];

        // Pastikan asesi ini adalah binaan asesor
        $asesi = Asesi::where('id_asesi', $id_asesi)
            ->where('asesor_id', $asesor->id_asesor)
            ->firstOrFail();

        // Ambil semua pertanyaan untuk skema & jenis ini, lengkap dengan opsi (untuk pg)
        $pertanyaan = Pertanyaan::where('id_skema', $id_skema)
            ->where('jenis_pertanyaan', $jenisDb)
            ->with(['opsiJawaban' => function ($q) {
                $q->orderBy('kode_opsi');
            }])
            ->get();

        if ($pertanyaan->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pertanyaan untuk jenis ini.');
        }

        // Ambil jawaban asesi
        $jawabanRaw = JawabanAsesmen::where('id_asesi', $id_asesi)
            ->where('id_skema', $id_skema)
            ->get()
            ->keyBy('id_pertanyaan');

        // Data tambahan: untuk pg, kita ingin tahu opsi mana yang benar
        $kunciJawaban = [];
        if ($jenisDb === 'pilihan_ganda') {
            foreach ($pertanyaan as $p) {
                $benar = $p->opsiJawaban->firstWhere('benar', 1);
                $kunciJawaban[$p->id_pertanyaan] = $benar ? $benar->id_opsi : null;
            }
        }

        $skema = DB::table('skema_sertifikasi')->where('id_skema', $id_skema)->first(['nama_skema']);

        return view('asesor.jawaban_show', compact(
            'pertanyaan',
            'jawabanRaw',
            'asesi',
            'skema',
            'jenisDb',
            'kunciJawaban',
            'id_skema',
            'jenis'
        ));
    }
    
    public function storePencapaian(Request $request)
    {
        if(!$request->pencapaian){
            return back()->with('error','Belum ada penilaian');
        }

        foreach($request->pencapaian as $id_jawaban => $nilai){

            JawabanAsesmen::where('id_jawaban',$id_jawaban)
                ->update([
                    'pencapaian' => $nilai
                ]);
        }

        return back()->with('success','Penilaian berhasil disimpan');
    }
}

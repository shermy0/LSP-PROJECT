<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pertanyaan;
use App\Models\JawabanAsesmen;
use App\Models\Asesi;
use App\Models\PembuatanPertanyaan;

class JawabanController extends Controller
{
    /**
     * Tampilkan daftar pertanyaan sesuai skema & jenis soal
     */
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
            'sisaDetik'
        ));
    }
    
    
    /**
     * Simpan atau update jawaban user
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
            'jenis' => 'required|in:lisan,esai,pilihan_ganda',
            'jawaban' => 'required|array'
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
    
        \DB::transaction(function() use ($request, $idAsesi, $asesi) {
            foreach ($request->jawaban as $id_pertanyaan => $text) {
        
                $pencapaian = null; 
        
                if ($request->jenis === 'pilihan_ganda') {
                    // Ambil id_opsi yang benar (kunci jawaban) dari opsi_jawaban
                    $idOpsiKunci = DB::table('opsi_jawaban')
                        ->where('id_pertanyaan', $id_pertanyaan)
                        ->where('benar', 1)
                        ->value('id_opsi'); // ini id_opsi jawaban yang benar
                
                    // Jawaban user (langsung id_opsi yang dikirim dari form)
                    $jawabanUserId = intval($text);
                
                    // Bandingkan jawaban user dengan id_opsi kunci
                    $pencapaian = ($idOpsiKunci && $idOpsiKunci === $jawabanUserId) ? 1 : 0;
                
                    // Simpan ke jawaban_asesmen
                    JawabanAsesmen::updateOrCreate(
                        [
                            'id_asesi' => $idAsesi,
                            'id_skema' => $request->id_skema,
                            'id_pertanyaan' => $id_pertanyaan
                        ],
                        [
                            'jawaban_opsi' => $jawabanUserId, // simpan id_opsi
                            'jawaban_text' => null,
                            'pencapaian'   => $pencapaian,
                        ]
                    );    
                } else {
                    // untuk esai / lisan
                    JawabanAsesmen::updateOrCreate(
                        [
                            'id_asesi' => $idAsesi,
                            'id_skema' => $request->id_skema,
                            'id_pertanyaan' => $id_pertanyaan
                        ],
                        [
                            'jawaban_opsi' => null,
                            'jawaban_text' => $text,
                            'pencapaian'   => null, // esai/lisan dinilai manual
                        ]
                    );
                }
            }
    
            // Simpan tanda tangan jika ada
            if ($request->filled('ttd_asesi')) {
                $ttdData = preg_replace('#^data:image/\w+;base64,#i', '', $request->ttd_asesi);
                $ttdData = str_replace(' ', '+', $ttdData);
                $imageData = base64_decode($ttdData);
                $jenis = $request->jenis;
    
                $namaAsesi = Str::slug($asesi->nama_lengkap, '_');
                $tanggal = $request->tgl_ttd_asesi ?: date('Y-m-d');
                $fileName = 'ttd_asesmen_'.$namaAsesi . '_' . $jenis . '_'. $tanggal . '.png';
                $filePath = storage_path('app/public/ttd/' . $fileName);
    
                if (!file_exists(dirname($filePath))) {
                    mkdir(dirname($filePath), 0755, true);
                }
    
                file_put_contents($filePath, $imageData);
    
                $lastJawaban = JawabanAsesmen::where('id_asesi', $idAsesi)
                    ->where('id_skema', $request->id_skema)
                    ->orderBy('id_jawaban', 'desc')
                    ->first();
    
                if ($lastJawaban) {
                    DB::table('jawaban_asesmen_persetujuan')->updateOrInsert(
                        ['id_jawaban' => $lastJawaban->id_jawaban],
                        [
                            'tgl_ttd_asesi' => $tanggal,
                            'ttd_asesi' => 'storage/ttd/' . $fileName,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        });
    
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
    
        return redirect()->route('asesi.dashboard')->with('success', 'Jawaban berhasil disimpan!');
    }
    
    
}

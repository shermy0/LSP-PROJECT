<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Asesor;
use App\Models\Permohonan;
use App\Models\PersetujuanAsesmen;
use App\Models\MasterJenisBukti;
use App\Models\Tuk;

class PersetujuanAsesmenController extends Controller
{
    /**
     * Daftar permohonan/asesi yang ditugaskan ke asesor.
     */
    public function index()
    {
        $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();
        $permohonan = Permohonan::whereHas('asesi', function ($q) use ($asesor) {
            $q->where('asesor_id', $asesor->id_asesor);
        })
        ->whereHas('asesmenMandiriMaster', function ($q) {
            $q->where('rekomendasi', 'Dapat Dilanjutkan');
        })
        ->with(['asesi', 'skema', 'persetujuan'])
        ->paginate(10);

        return view('asesor.persetujuan_asesmen.index', compact('permohonan'));
    }

    /**
     * Form buat persetujuan (data umum) untuk asesi tertentu.
     */
    public function create($id_permohonan)
    {
        $permohonan = Permohonan::with(['asesi', 'skema'])->findOrFail($id_permohonan);
        $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

        if ($permohonan->asesi->asesor_id != $asesor->id_asesor) {
            abort(403);
        }

        // Cek apakah sudah ada persetujuan
        if ($permohonan->persetujuan) {
            return redirect()->route('asesor.persetujuan_asesmen.show', $permohonan->persetujuan->id_persetujuan)
                ->with('info', 'Persetujuan sudah ada.');
        }

        $tukList = DB::table('tuk')->get();
        $jenisBukti = MasterJenisBukti::all(); // tetap dikirim untuk referensi

        return view('asesor.persetujuan_asesmen.create', compact('permohonan', 'tukList', 'jenisBukti'));
    }

    /**
     * Menyimpan data umum persetujuan (draft) – tanpa tanda tangan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_permohonan' => 'required|exists:permohonan,id_permohonan',
            'id_tuk' => 'required',
            'tgl_pelaksanaan' => 'nullable|date',
            'waktu' => 'nullable',
            'setuju_asesmen' => 'nullable|boolean',
            'bukti' => 'nullable|array',
            'bukti_lainnya' => 'nullable|string',
        ]);

        // Validasi tambahan jika memilih 'lainnya' pada TUK
        if ($request->id_tuk === 'lainnya') {
            $request->validate([
                'tuk_baru_nama' => 'required|string|max:255',
                'tuk_baru_jenis' => 'required|string',
                'tuk_baru_alamat' => 'required|string',
            ]);
        }

        DB::beginTransaction();
        try {
            $permohonan = Permohonan::findOrFail($request->id_permohonan);
            $asesor = Asesor::where('user_id', Auth::id())->firstOrFail();

            // Tentukan id_tuk
            $id_tuk = $request->id_tuk;
            if ($request->id_tuk === 'lainnya') {
                // Buat TUK baru
                $tukBaru = Tuk::create([
                    'nama_tuk' => $request->tuk_baru_nama,
                    'jenis_tuk' => $request->tuk_baru_jenis,
                    'alamat_tuk' => $request->tuk_baru_alamat,
                    'status_tuk' => 'Aktif',
                ]);
                $id_tuk = $tukBaru->id_tuk;
            }

            // Simpan data utama persetujuan
            $persetujuan = PersetujuanAsesmen::create([
                'id_permohonan' => $request->id_permohonan,
                'id_asesi' => $permohonan->id_asesi,
                'id_asesor' => $asesor->id_asesor,
                'id_skema' => $permohonan->id_skema,
                'id_tuk' => $id_tuk,
                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                'waktu' => $request->waktu,
                // Hari dan lokasi tidak ada di form, biarkan null
                'hari' => null,
                'lokasi' => null,
                'pernyataan_kerahasiaan' => null, // tidak ada di form
                'setuju_asesmen' => $request->setuju_asesmen ?? false,
                'status' => 'draf',
            ]);

            // Proses bukti yang dipilih (menggunakan nama bukti, bukan id)
            if ($request->has('bukti')) {
                $masterBukti = MasterJenisBukti::all()->keyBy('nama_bukti'); // asumsi kolom nama_bukti

                foreach ($request->bukti as $namaBukti) {
                    if ($namaBukti === 'lainnya') {
                        // Untuk 'lainnya', kita butuh id dari master_jenis_bukti yang mewakili "Lainnya"
                        // Asumsikan ada entry dengan nama "Lainnya" di master_jenis_bukti
                        $master = MasterJenisBukti::where('nama_bukti', 'Lainnya')->first();
                        if ($master) {
                            DB::table('persetujuan_asesmen_bukti')->insert([
                                'id_persetujuan' => $persetujuan->id_persetujuan,
                                'id_jenis_bukti' => $master->id_jenis_bukti,
                                'dipilih' => true,
                                'deskripsi' => $request->bukti_lainnya, // simpan teks lainnya
                            ]);
                        }
                    } else {
                        // Cari id berdasarkan nama bukti
                        $master = MasterJenisBukti::where('nama_bukti', $namaBukti)->first();
                        if ($master) {
                            DB::table('persetujuan_asesmen_bukti')->insert([
                                'id_persetujuan' => $persetujuan->id_persetujuan,
                                'id_jenis_bukti' => $master->id_jenis_bukti,
                                'dipilih' => true,
                                'deskripsi' => null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('asesor.persetujuan_asesmen.show', $persetujuan->id_persetujuan)
                ->with('success', 'Draf persetujuan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail persetujuan (untuk asesor maupun asesi).
     */
    public function show($id)
    {
        $persetujuan = PersetujuanAsesmen::with([
            'permohonan.asesi',
            'permohonan.skema',
            'asesor',
            'buktiTerpilih.jenisBukti',
            'ttd'
        ])->findOrFail($id);

        $user = Auth::user();
        $role = $user->role;

        // Cek otorisasi
        if ($role === 'asesor') {
            $asesor = Asesor::where('user_id', $user->id)->firstOrFail();
            if ($persetujuan->id_asesor != $asesor->id_asesor) {
                abort(403);
            }
        } elseif ($role === 'asesi') {
            $asesi = DB::table('asesi')->where('user_id', $user->id)->first();
            if ($persetujuan->id_asesi != $asesi->id_asesi) {
                abort(403);
            }
        } else {
            abort(403);
        }

        $jenisBukti = MasterJenisBukti::all();
        $tukList = DB::table('tuk')->get();

        return view($role . '.persetujuan_asesmen.show', compact('persetujuan', 'jenisBukti', 'tukList'));
    }

    /**
     * Update data umum persetujuan (hanya jika status draf dan role asesor).
     */
    public function update(Request $request, $id)
    {
        // Method ini tidak digunakan dalam form baru (create), karena form hanya untuk create.
        // Bisa diabaikan atau disesuaikan jika diperlukan.
        abort(404);
    }

    /**
     * Menyimpan tanda tangan (dari halaman show).
     */
    public function storeSignature(Request $request, $id)
    {
        $persetujuan = PersetujuanAsesmen::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'asesi') {
            // Asesi menandatangani: hanya boleh jika status = 'draf'
            if ($persetujuan->status !== 'draf') {
                return back()->with('error', 'Tidak dapat menandatangani pada status ini.');
            }
            $request->validate([
                'ttd_asesi' => 'required|string',
                'tgl_ttd_asesi' => 'required|date',
            ]);

            $ttdPath = $this->saveSignature($request->ttd_asesi, 'asesi');
            DB::table('persetujuan_asesmen_persetujuan')->updateOrInsert(
                ['id_persetujuan' => $id],
                [
                    'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                    'ttd_asesi' => $ttdPath,
                ]
            );
            $persetujuan->update(['status' => 'menunggu_asesor']);

        } elseif ($user->role === 'asesor') {
            // Asesor menandatangani: hanya boleh jika status = 'menunggu_asesor'
            if ($persetujuan->status !== 'menunggu_asesor') {
                return back()->with('error', 'Tidak dapat menandatangani pada status ini.');
            }
            $asesor = Asesor::where('user_id', $user->id)->firstOrFail();
            if ($persetujuan->id_asesor != $asesor->id_asesor) {
                abort(403);
            }

            $request->validate([
                'ttd_asesor' => 'required|string',
                'tgl_ttd_asesor' => 'required|date',
            ]);

            $ttdPath = $this->saveSignature($request->ttd_asesor, 'asesor');
            DB::table('persetujuan_asesmen_persetujuan')->updateOrInsert(
                ['id_persetujuan' => $id],
                [
                    'tgl_ttd_asesor' => $request->tgl_ttd_asesor,
                    'ttd_asesor' => $ttdPath,
                ]
            );
            $persetujuan->update(['status' => 'selesai']);

        } else {
            abort(403);
        }

        return redirect()->route($user->role . '.persetujuan_asesmen.show', $id)
            ->with('success', 'Tanda tangan berhasil disimpan.');
    }

    private function saveSignature($base64, $prefix)
    {
        $image = str_replace('data:image/png;base64,', '', $base64);
        $image = str_replace(' ', '+', $image);
        $fileName = $prefix . '_' . time() . '.png';
        Storage::disk('public')->put('ttd/' . $fileName, base64_decode($image));
        return 'ttd/' . $fileName;
    }
}
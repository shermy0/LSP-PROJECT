<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\OpsiJawaban;
use App\Models\Users;
use App\Models\Skema;
use App\Models\PMO;
use App\Models\Asesor;
use App\Models\kelompokPekerjaan;
use App\Models\PembuatanPertanyaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\JawabanPMO; // pastikan model JawabanPMO sudah ada


class PertanyaanController extends Controller
{
    // ================================
    // INDEX (CRUD List Semua Pertanyaan)
    // ================================
    public function index()
    {
        $pertanyaan = Pertanyaan::all();
        return view('pertanyaan.index', compact('pertanyaan'));
    }

// ================================
    // CRUD LISAN
    // ================================
    public function createLisan(Request $request)
    {
        $jumlah = $request->query('jumlah', 5);
        $id_skema = $request->query('id_skema');

        $skema = Skema::findOrFail($id_skema);

        // Buat record pembuatan pertanyaan
        $pembuatan = PembuatanPertanyaan::create([
            'id_skema' => $id_skema,
            'timer' => $request->query('timer', 0),
            'timescap' => now(),
        ]);

        $idKelompok = KelompokPekerjaan::where('id_skema', $id_skema)->value('id_kelompok') ?? null;

        return view('input_lisan', [
            'skema' => $skema,
            'jumlah' => $jumlah,
            'idPembuatanPertanyaan' => $pembuatan->id_pembuatan_pertanyaan,
            'idKelompok' => $idKelompok
        ]);
    }

    public function storeLisan(Request $request)
    {
        $request->validate([
            'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
            'id_asesor' => 'required|exists:asesor,id_asesor',
            'id_kelompok' => 'nullable|exists:kelompok_pekerjaan,id_kelompok',
            'id_pembuatan_pertanyaan' => 'nullable|exists:pembuatan_pertanyaan,id_pembuatan_pertanyaan',
            'isi_pertanyaan.*' => 'required|string',
            'kunci_jawaban.*' => 'nullable|string',
        ]);

        foreach ($request->isi_pertanyaan as $key => $isi) {
            Pertanyaan::create([
                'id_skema' => $request->id_skema,
                'id_asesor' => $request->id_asesor,
                'id_kelompok' => $request->id_kelompok,
                'id_pembuatan_pertanyaan' => $request->id_pembuatan_pertanyaan,
                'jenis_pertanyaan' => 'lisan',
                'isi_pertanyaan' => $isi,
                'kunci_jawaban' => $request->kunci_jawaban[$key] ?? null,
            ]);
        }

        return redirect()->route('lisan.crud', $request->id_skema)
            ->with('success', 'Pertanyaan lisan berhasil ditambahkan!');
    }

    public function editLisan($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        return view('input_lisan_edit', compact('pertanyaan'));
    }

    public function updateLisan(Request $request, $id)
    {
        $request->validate([
            'isi_pertanyaan' => 'required|string',
            'kunci_jawaban' => 'nullable|string',
        ]);

        $pertanyaan = Pertanyaan::findOrFail($id);
        $pertanyaan->update([
            'isi_pertanyaan' => $request->isi_pertanyaan,
            'kunci_jawaban' => $request->kunci_jawaban
        ]);

        return redirect()->route('lisan.crud', $pertanyaan->id_skema)
            ->with('success', 'Pertanyaan lisan berhasil diperbarui');
    }

    public function crudLisan($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        $kelompok = KelompokPekerjaan::with(['pertanyaan' => function($q) {
            $q->where('jenis_pertanyaan', 'lisan');
        }])->where('id_skema', $id_skema)->first(); // <── pakai first()

        return view('lisan_crud', compact('skema', 'kelompok'));
    }
    

    // ================================
    // FORM ESAI
    // ================================
    public function createEsai(Request $request)
    {
        $jumlah   = $request->query('jumlah', 5); 
        $id_skema = $request->query('id_skema');

        $skema = Skema::findOrFail($id_skema);

        return view('input_esai', compact('skema', 'jumlah'));
    }

  public function storeEsai(Request $request)
{
    $request->validate([
        'id_skema'         => 'required|integer',
        'id_asesor'        => 'required|integer',
        'id_kelompok'      => 'required|integer',
        'isi_pertanyaan.*' => 'required|string',
        'kunci_jawaban.*'  => 'nullable|string',
        'file.*'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        'timer'            => 'required|integer',
        'judul'            => 'nullable|string',
    ]);

    $id_skema    = $request->id_skema;
    $id_asesor   = $request->id_asesor;
    $id_kelompok = $request->id_kelompok;

    if ($request->filled('id_pembuatan_pertanyaan')) {
        $pembuatan = PembuatanPertanyaan::findOrFail($request->id_pembuatan_pertanyaan);
        $pembuatan->update([
            // ✅ kalau judul tidak diisi, pakai judul lama (jangan pakai tanggal)
            'judul'            => $request->filled('judul') ? $request->judul : $pembuatan->judul,
            'timer'            => $request->timer,
            'timescap'         => now(),
            'jenis_pertanyaan' => 'esai',
        ]);
    } else {
        $pembuatan = PembuatanPertanyaan::create([
            'id_skema'         => $id_skema,
            // ✅ kalau judul tidak diisi saat buat baru, pakai string sederhana tanpa tanggal
            'judul'            => $request->filled('judul') ? $request->judul : 'Pertanyaan Esai',
            'timer'            => $request->timer,
            'timescap'         => now(),
            'jenis_pertanyaan' => 'esai',
        ]);
    }

    // Simpan pertanyaan
    foreach ($request->isi_pertanyaan as $key => $isi) {
        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_skema                = $id_skema;
        $pertanyaan->id_kelompok             = $id_kelompok;
        $pertanyaan->id_asesor               = $id_asesor;
        $pertanyaan->id_pembuatan_pertanyaan = $pembuatan->id_pembuatan_pertanyaan;
        $pertanyaan->jenis_pertanyaan        = 'esai';
        $pertanyaan->isi_pertanyaan          = $isi;
        $pertanyaan->kunci_jawaban           = $request->kunci_jawaban[$key] ?? null;

        if ($request->hasFile("file.$key")) {
            $file = $request->file("file.$key");
            $pertanyaan->file_path = $file->store('uploads/pertanyaan', 'public');
            $pertanyaan->file_type = $file->getClientOriginalExtension();
        }

        $pertanyaan->save();
    }

    return redirect()->route('esai.crud', [
        'id_skema'    => $id_skema,
        'id_kelompok' => $id_kelompok,
    ])->with('success', 'Semua pertanyaan esai berhasil disimpan!');
}public function crudEsai($id_skema, $id_kelompok)
{
    $skema = Skema::findOrFail($id_skema);

    $pertanyaan = Pertanyaan::where('id_skema', $id_skema)
        ->where('id_kelompok', $id_kelompok)
        ->where('jenis_pertanyaan', 'esai')
        ->get();

    $firstPertanyaan = $pertanyaan->first();

    $pembuatan_pertanyaan = null;
    if ($firstPertanyaan && $firstPertanyaan->id_pembuatan_pertanyaan) {
        $pembuatan_pertanyaan = PembuatanPertanyaan::find($firstPertanyaan->id_pembuatan_pertanyaan);
    }

    $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
        ->where('jenis_pertanyaan', 'esai')
        ->orderBy('timescap', 'desc')
        ->get();

    return view('esai_crud', compact(
        'id_skema',
        'id_kelompok',
        'skema',
        'pertanyaan',
        'firstPertanyaan',
        'pembuatan_pertanyaan',
        'pembuatanList'
    ));
}

   // Tampilkan form edit 1 pertanyaan
public function editPertanyaanEsai($id_pertanyaan)
{
    $pertanyaan = Pertanyaan::findOrFail($id_pertanyaan);
    return view('input_esai_edit', compact('pertanyaan'));
}

// Simpan perubahan 1 pertanyaan
public function updatePertanyaanEsai(Request $request, $id_pertanyaan)
{
    $pertanyaan = Pertanyaan::findOrFail($id_pertanyaan);

    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
            \Storage::disk('public')->delete($pertanyaan->file_path);
        }
        $pertanyaan->file_path = $request->file('file')->store('pertanyaan_files', 'public');
        $pertanyaan->file_type = $request->file('file')->getClientOriginalExtension();
    }

    $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
    $pertanyaan->kunci_jawaban  = $request->kunci_jawaban;
    $pertanyaan->save();

    // ✅ Ganti return redirect ke sini
    return redirect()->route('esai.crud', [
        'id_skema'    => $pertanyaan->id_skema,
        'id_kelompok' => $pertanyaan->id_kelompok,
    ])->with('success', 'Pertanyaan berhasil diperbarui!');
}

// Hapus 1 pertanyaan
public function deletePertanyaanEsai($id_pertanyaan)
{
    $pertanyaan = Pertanyaan::findOrFail($id_pertanyaan);

    if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
        \Storage::disk('public')->delete($pertanyaan->file_path);
    }

    $pertanyaan->delete();

    return back()->with('success', 'Pertanyaan berhasil dihapus!');
}

 // ================================
// FORM PILIHAN GANDA (PG)
// ================================
public function createPG(Request $request)
{

    $request->validate([
        'jumlah' => 'required|integer|min:1|max:20',
        'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
        'id_kelompok' => 'required|exists:kelompok_pekerjaan,id_kelompok',
        'timer' => 'required|integer|min:1',
        'id_pembuatan_pertanyaan' => 'nullable|exists:pembuatan_pertanyaan,id_pembuatan_pertanyaan'
    ]);

    $jumlah = $request->query('jumlah', 5);
    $id_skema = $request->query('id_skema');
    $id_kelompok = $request->query('id_kelompok');
    $timer = $request->query('timer', 30);
    $id_pembuatan = $request->query('id_pembuatan_pertanyaan');

    $skema = Skema::findOrFail($id_skema);
    $kelompok = KelompokPekerjaan::findOrFail($id_kelompok);



    // Jika ada id_pembuatan_pertanyaan, ambil timer dari database
    if ($id_pembuatan) {
        $pembuatan = PembuatanPertanyaan::findOrFail($id_pembuatan);
        $timer = $pembuatan->timer;
    }

    return view('pertanyaan.input_pg', [
        'skema' => $skema,
        'kelompok' => $kelompok,
        'jumlah' => $jumlah,
        'timer' => $timer,
        'id_pembuatan_pertanyaan' => $id_pembuatan
    ]);
}

public function storePMO(Request $request, $id_pmo)
{
    // Validasi input
    $request->validate([
        'pertanyaan' => 'required|string',
        'id_unit' => 'required|array',
    ]);

    // Simpan ke tabel pmo_pertanyaan
    foreach ($request->id_unit as $id_unit) {
        \App\Models\PMO::create([
            'id_pmo' => $id_pmo,
            'id_unit' => $id_unit,
            'pertanyaan' => $request->pertanyaan,
            'deskripsi_pertanyaan' => $request->deskripsi_pertanyaan,
        ]);
    }

    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Pertanyaan PMO berhasil disimpan!');
}

    public function storePG(Request $request)
    {


        try {
            $validated = $request->validate([
                'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
                'id_kelompok' => 'required|exists:kelompok_pekerjaan,id_kelompok',
                'id_pembuatan_pertanyaan' => 'nullable|exists:pembuatan_pertanyaan,id_pembuatan_pertanyaan',
                'timer' => 'required|integer|min:1',
                'isi_pertanyaan' => 'required|array|min:1',
                'isi_pertanyaan.*' => 'required|string|min:1',
                'jenis_opsi' => 'required|array',
                'jenis_opsi.*' => 'required|array|min:1',
                'jenis_opsi.*.*' => 'required|string|in:text,gambar',
                'opsi_text' => 'nullable|array',
                'opsi_text.*' => 'nullable|array',
                'opsi_text.*.*' => 'nullable|string',
                'opsi_gambar' => 'nullable|array',
                'opsi_gambar.*' => 'nullable|array',
                'opsi_gambar.*.*' => 'nullable|file|mimes:jpg,jpeg,png',
                'kunci_jawaban' => 'required|array',
                'kunci_jawaban.*' => 'required|string|in:A,B,C,D,E',
                'file.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();
        try {


            // 🔹 LOGIKA TIMER SAMA PERSIS DENGAN ESAI
            if ($request->filled('id_pembuatan_pertanyaan')) {
                // Mode LANJUTKAN - gunakan timer yang sudah ada di database
                $pembuatan = PembuatanPertanyaan::findOrFail($request->id_pembuatan_pertanyaan);
                $pembuatan->update([
                    'timescap'         => now(),
                    'jenis_pertanyaan' => 'pilihan_ganda',
                    // Timer tidak diubah, tetap pakai yang lama
                ]);
            } else {
                // Mode SELANJUTKAN - buat record baru dengan timer dari input
                $pembuatan = PembuatanPertanyaan::create([
                    'id_skema'         => $request->id_skema,
                    'timer'            => $request->timer, // Timer dari input modal
                    'timescap'         => now(),
                    'jenis_pertanyaan' => 'pilihan_ganda',
                ]);
            }

            $id_asesor = auth()->user()->asesor->id_asesor;

            // Simpan pertanyaan dan opsi
            foreach ($request->isi_pertanyaan as $i => $isi) {
                if (empty(trim($isi))) continue;

            

                // Handle file pertanyaan
                $filePath = null;
                $fileType = null;
                if ($request->hasFile("file.$i") && $request->file("file.$i")->isValid()) {
                    $file = $request->file("file.$i");
                    $filePath = $file->store("uploads/pertanyaan", "public");
                    $fileType = $file->getClientOriginalExtension();
                }

                // Simpan pertanyaan
                $pertanyaan = Pertanyaan::create([
                    'id_skema'                => $request->id_skema,
                    'id_kelompok'             => $request->id_kelompok,
                    'id_pembuatan_pertanyaan' => $pembuatan->id_pembuatan_pertanyaan,
                    'id_asesor'               => $id_asesor,
                    'jenis_pertanyaan'        => 'pilihan_ganda',
                    'isi_pertanyaan'          => $isi,
                    'file_path'               => $filePath,
                    'file_type'               => $fileType,
                    'kunci_jawaban'           => $request->kunci_jawaban[$i],
                ]);

                // Simpan opsi jawaban
                if (isset($request->jenis_opsi[$i])) {
                    foreach ($request->jenis_opsi[$i] as $j => $jenis) {
                        $kode = chr(65 + $j); // A, B, C, D, E
                        $isiOpsi = null;

                        if ($jenis === 'text') {
                            $isiOpsi = $request->opsi_text[$i][$j] ?? '';
                        } elseif ($jenis === 'gambar') {
                            if ($request->hasFile("opsi_gambar.$i.$j") && $request->file("opsi_gambar.$i.$j")->isValid()) {
                                $fileOpsi = $request->file("opsi_gambar.$i.$j");
                                $filePath = $fileOpsi->store("uploads/opsi_jawaban", "public");
                                $isiOpsi = $filePath;
                            }
                        }

                        if (!empty($isiOpsi)) {
                            OpsiJawaban::create([
                                'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                                'kode_opsi'     => $kode,
                                'isi_opsi'      => $isiOpsi,
                                'benar'         => ($request->kunci_jawaban[$i] === $kode) ? 1 : 0,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            
            return redirect()->route('pg.crud', [
                'id_skema'    => $request->id_skema,
                'id_kelompok' => $request->id_kelompok
            ])->with('success', 'Pertanyaan pilihan ganda berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('StorePG error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan pertanyaan: ' . $e->getMessage())->withInput();
        }
    }




public function crudPG($id_skema, $id_kelompok)
{
    // Ambil data skema
    $skema = Skema::findOrFail($id_skema);

    // Ambil semua pertanyaan PG beserta opsi jawabannya
    $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'pilihan_ganda')
        ->where('id_skema', $id_skema)
        ->where('id_kelompok', $id_kelompok)
        ->with(['opsiJawaban' => function ($query) {
            $query->orderBy('kode_opsi'); // urutkan opsi A, B, C, D
        }])
        ->get();

    // Ambil data pembuatan pertanyaan (hanya kalau ada pertanyaan)
    $pembuatan_pertanyaan = $pertanyaan->isNotEmpty()
        ? PembuatanPertanyaan::find($pertanyaan->first()->id_pembuatan_pertanyaan)
        : null;

        // Ambil semua asesor (kalau perlu ditampilkan di view)
        $asesor = DB::table('asesor')
        ->leftJoin('pertanyaan_asesmen_persetujuan', function($join) use ($pembuatan_pertanyaan) {
            $join->on('asesor.id_asesor', '=', 'pertanyaan_asesmen_persetujuan.id_asesor')
                 ->where('pertanyaan_asesmen_persetujuan.id_pembuatan_pertanyaan', $pembuatan_pertanyaan->id_pembuatan_pertanyaan);
        })
        ->select(
            'asesor.id_asesor',
            'asesor.nama_asesor',
            'asesor.no_registrasi',
            'pertanyaan_asesmen_persetujuan.tgl_ttd_asesor'
        )
        ->orderBy('asesor.nama_asesor')
        ->get();

    // Kirim data ke view
    return view('pertanyaan.pg_crud', compact(
        'pertanyaan',
        'skema',
        'id_kelompok',
        'pembuatan_pertanyaan',
        'asesor'
    ));
}


public function editPG($id)
{
    $pertanyaan = Pertanyaan::with(['opsiJawaban' => function($query) {
        $query->orderBy('kode_opsi'); // Urutkan berdasarkan kode A, B, C, D, E
    }])->findOrFail($id);
    
    $skema = Skema::find($pertanyaan->id_skema);

    return view('pertanyaan.input_pg_edit', compact('pertanyaan', 'skema'));
}

public function updatePG(Request $request, $id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);

    $request->validate([
        'isi_pertanyaan' => 'required|string',
        'kunci_jawaban' => 'required|string|in:A,B,C,D,E',
        'jenis_opsi' => 'required|array|min:2',
        'jenis_opsi.*' => 'required|string|in:text,gambar',
        'opsi_text' => 'required|array',
        'opsi_text.*' => 'nullable|string',
        'opsi_gambar.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        'opsi_gambar_lama.*' => 'nullable|string',
        'file' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        'hapus_file' => 'nullable',
    ]);

    DB::beginTransaction();
    try {
        // File pertanyaan
        if ($request->hasFile('file')) {
            if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
                \Storage::disk('public')->delete($pertanyaan->file_path);
            }
            $file = $request->file('file');
            $pertanyaan->file_path = $file->store('uploads/pertanyaan', 'public');
            $pertanyaan->file_type = $file->getClientOriginalExtension();
        } elseif ($request->has('hapus_file')) {
            if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
                \Storage::disk('public')->delete($pertanyaan->file_path);
            }
            $pertanyaan->file_path = null;
            $pertanyaan->file_type = null;
        }

        // Update pertanyaan
        $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
        $pertanyaan->kunci_jawaban = $request->kunci_jawaban;
        $pertanyaan->save();

        // Hapus opsi lama
        $opsiLama = OpsiJawaban::where('id_pertanyaan', $id)->get();
        foreach ($opsiLama as $opsi) {
            if ($opsi->isi_opsi && str_contains($opsi->isi_opsi, 'uploads/opsi_jawaban') && 
                \Storage::disk('public')->exists($opsi->isi_opsi)) {
                \Storage::disk('public')->delete($opsi->isi_opsi);
            }
        }
        OpsiJawaban::where('id_pertanyaan', $id)->delete();

        // Simpan opsi baru
        foreach ($request->jenis_opsi as $j => $jenis) {
            $kode = chr(65 + $j);
            $isiOpsi = null;

            if ($jenis === 'text') {
                $isiOpsi = $request->opsi_text[$j] ?? '';
            } elseif ($jenis === 'gambar') {
                if ($request->hasFile("opsi_gambar.$j") && $request->file("opsi_gambar.$j")->isValid()) {
                    $fileOpsi = $request->file("opsi_gambar.$j");
                    $fileName = "opsi_{$id}_{$kode}_" . now()->format('YmdHis') . "." . $fileOpsi->getClientOriginalExtension();
                    $isiOpsi = $fileOpsi->storeAs("uploads/opsi_jawaban", $fileName, "public");
                } elseif (!empty($request->opsi_gambar_lama[$j])) {
                    $isiOpsi = $request->opsi_gambar_lama[$j];
                }
            }

            OpsiJawaban::create([
                'id_pertanyaan' => $id,
                'kode_opsi' => $kode,
                'isi_opsi' => $isiOpsi ?? '',
                'benar' => ($request->kunci_jawaban == $kode) ? 1 : 0,
            ]);
        }

        DB::commit();
        return redirect()->route('pg.crud', [
            'id_skema' => $pertanyaan->id_skema,
            'id_kelompok' => $pertanyaan->id_kelompok
        ])->with('success', 'Pertanyaan PG berhasil diupdate!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal update: '.$e->getMessage())->withInput();
    }
}


public function destroyPG($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);

    if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
        \Storage::disk('public')->delete($pertanyaan->file_path);
    }

    OpsiJawaban::where('id_pertanyaan', $id)->delete();
    $pertanyaan->delete();

    return redirect()->route('pg.crud', [
        'id_skema' => $pertanyaan->id_skema,
        'id_kelompok' => $pertanyaan->id_kelompok
    ])->with('success', 'Pertanyaan PG berhasil dihapus!');
}


public function kelompokPekerjaan(Request $request, $id_skema, $jenis = null)
{
    $jenis = $jenis ?? $request->query('jenis', 'esai');
    $judul = $request->query('judul');
    $timer = $request->query('timer');
    $idPembuatan = $request->query('id_pembuatan_pertanyaan');

    // kalau user klik "Lanjutkan"
    if ($idPembuatan) {
        $pembuatan = PembuatanPertanyaan::find($idPembuatan);
        if (!$pembuatan) {
            return back()->with('error', 'Data pembuatan pertanyaan tidak ditemukan.');
        }
        $timer = $pembuatan->timer;
    }
    // kalau user klik "Buat Baru"
    else if ($judul) {
        $pembuatan = PembuatanPertanyaan::create([
            'id_skema'         => $id_skema,
            'judul'            => $judul,
            'timer'            => $timer ?? 30,
            'timescap'         => now(),
            'jenis_pertanyaan' => $jenis,
        ]);
    }
    // kalau buka halaman tanpa judul baru / lanjutkan
    else {
        $pembuatan = PembuatanPertanyaan::where('id_skema', $id_skema)
                        ->where('jenis_pertanyaan', $jenis)
                        ->latest('id_pembuatan_pertanyaan')
                        ->first();
        if (!$pembuatan) {
            return back()->with('error', 'Belum ada pembuatan pertanyaan sebelumnya.');
        }
        $timer = $pembuatan->timer;
    }

    $kelompok = KelompokPekerjaan::with(['unitKompetensi' => function ($q) use ($id_skema) {
        $q->where('unit_kompetensi.id_skema', $id_skema);
    }])->where('id_skema', $id_skema)->get();

    $skema = Skema::find($id_skema);

    // ✅ Ambil soal berdasarkan id_pembuatan_pertanyaan
    $soalList = $pembuatan
        ? Pertanyaan::where('id_pembuatan_pertanyaan', $pembuatan->id_pembuatan_pertanyaan)
            ->with('kelompok') // pastikan relasi kelompok ada di model Pertanyaan
            ->get()
        : collect();

    return view('kelompok_pekerjaan_essai', [
        'kelompok'  => $kelompok,
        'timer'     => $timer,
        'id_skema'  => $id_skema,
        'jenis'     => $jenis,
        'judul'     => $judul,
        'skema'     => $skema,
        'pembuatan' => $pembuatan,
        'soalList'  => $soalList, // ✅ dikirim ke view
    ]);
}

public function kelompokPekerjaanPG(Request $request, $id_skema, $id_pembuatan_pertanyaan = null)
{
    $jenis = $request->query('jenis', 'pilihan_ganda');

    $judul = $request->query('judul');
    $timer = $request->query('timer');

    // =========================
    // LANJUTKAN PEMBUATAN
    // =========================
    if ($id_pembuatan_pertanyaan) {

        $pembuatan = PembuatanPertanyaan::find($id_pembuatan_pertanyaan);

        if (!$pembuatan) {
            return back()->with('error', 'Data pembuatan pertanyaan tidak ditemukan.');
        }

        $timer = $pembuatan->timer;
    }

    // =========================
    // BUAT BARU
    // =========================
    elseif ($judul) {

        $pembuatan = PembuatanPertanyaan::create([
            'id_skema' => $id_skema,
            'judul' => $judul,
            'timer' => $timer ?? 30,
            'timescap' => now(),
            'jenis_pertanyaan' => 'pilihan_ganda',
        ]);
    }

    else {
        return back()->with('error', 'Parameter tidak lengkap.');
    }

    $kelompok = KelompokPekerjaan::with(['unitKompetensi' => function ($q) use ($id_skema) {
        $q->where('unit_kompetensi.id_skema', $id_skema);
    }])->where('id_skema', $id_skema)->get();

    $skema = Skema::find($id_skema);

    $soalList = Pertanyaan::where('id_pembuatan_pertanyaan', $pembuatan->id_pembuatan_pertanyaan)
        ->with('kelompok')
        ->get();

    return view('kelompok_pekerjaan_pg', [
        'kelompok'  => $kelompok,
        'timer'     => $timer,
        'id_skema'  => $id_skema,
        'jenis'     => $jenis,
        'judul'     => $pembuatan->judul,
        'skema'     => $skema,
        'pembuatan' => $pembuatan,
        'soalList'  => $soalList,
    ]);
}
    // ================================
    // FORM TANDA TANGAN ASESOR
    // ================================
    public function formTTDAsesor($id_skema, $id_pembuatan_pertanyaan)
    {
        $user = auth()->user(); 
        $asesorLogin = Asesor::where('user_id', $user->id)->first();

        // ambil data pembuatan pertanyaan sesuai id
        $pembuatan_pertanyaan = PembuatanPertanyaan::find($id_pembuatan_pertanyaan);
        $skema = Skema::find($id_skema);

        // cek apakah asesor sudah tanda tangan di tabel persetujuan
        $asesorSudahTTD = DB::table('pertanyaan_asesmen_persetujuan')
            ->join('asesor', 'asesor.id_asesor', '=', 'pertanyaan_asesmen_persetujuan.id_asesor')
            ->where('pertanyaan_asesmen_persetujuan.id_pembuatan_pertanyaan', $id_pembuatan_pertanyaan)
            ->select(
                'asesor.*',
                'pertanyaan_asesmen_persetujuan.id_pertanyaan_persetujuan',
                'pertanyaan_asesmen_persetujuan.ttd_asesor',
                'pertanyaan_asesmen_persetujuan.tgl_ttd_asesor'
            )
            ->get();

        return view('tanda_tangan_asesmen', compact(
            'asesorLogin',
            'asesorSudahTTD',
            'pembuatan_pertanyaan',
            'skema',
            'id_skema',
            'id_pembuatan_pertanyaan'
        ));
    }

    // ================================
    // SIMPAN TTD ASESOR
    // ================================
    public function simpanTTDAsesor(Request $request, $id_skema, $id_pembuatan_pertanyaan)
    {
        $validated = $request->validate([
            'id_pembuatan_pertanyaan' => 'required|exists:pembuatan_pertanyaan,id_pembuatan_pertanyaan',
            'id_asesor'               => 'required|exists:asesor,id_asesor',
            'tgl_ttd_asesor'          => 'required|date',
            'ttd_asesor'              => 'required'
        ]);
    
        // decode base64 ke file gambar
        $ttdData = $validated['ttd_asesor'];

        // Ambil data asesor langsung dari DB (lebih aman daripada hidden input)
        $asesor = Asesor::findOrFail($validated['id_asesor']);
        
        // Bikin nama file rapi, ganti spasi dengan underscore
        $slugNama = str_replace(' ', '_', strtolower($asesor->nama_asesor));
        
        $idPembuatan = $validated['id_pembuatan_pertanyaan'];

        // Nama file dengan id_pembuatan_pertanyaan + tanggal unik
        $ttdFileName = 'ttd_asesor_pertanyaan_asesmen_persetujuan_' 
                     . $slugNama . '_idpembuatan_' . $idPembuatan . '_' . date('Ymd') . '.png';
        
        // Path penyimpanan (pastikan folder storage/app/public/ttd sudah ada)
        $path = storage_path('app/public/ttd/' . $ttdFileName);
        
        // Hapus prefix base64
        $ttdData = str_replace('data:image/png;base64,', '', $ttdData);
        $ttdData = str_replace(' ', '+', $ttdData);
        
        // Simpan file
        \File::put($path, base64_decode($ttdData));
        
    
        // cek apakah sudah ada
        $existing = DB::table('pertanyaan_asesmen_persetujuan')
            ->where('id_pembuatan_pertanyaan', $validated['id_pembuatan_pertanyaan'])
            ->where('id_asesor', $validated['id_asesor'])
            ->first();
    
        if ($existing) {
            DB::table('pertanyaan_asesmen_persetujuan')
                ->where('id_pertanyaan_persetujuan', $existing->id_pertanyaan_persetujuan)
                ->update([
                    'tgl_ttd_asesor' => $validated['tgl_ttd_asesor'],
                    'ttd_asesor'     => $ttdFileName,
                ]);
        } else {
            DB::table('pertanyaan_asesmen_persetujuan')->insert([
                'id_pembuatan_pertanyaan' => $validated['id_pembuatan_pertanyaan'],
                'id_asesor'               => $validated['id_asesor'],
                'tgl_ttd_asesor'          => $validated['tgl_ttd_asesor'],
                'ttd_asesor'              => $ttdFileName,
            ]);
        }
    
        return redirect()->route('tanda.tangan.asesmen', [$id_skema, $id_pembuatan_pertanyaan])
                        ->with('success', 'TTD Asesor berhasil disimpan!');
    }

   // ================================
    // TAMPILAN PMO (Buat Pertanyaan)
    // ================================
public function createPMO(Request $request)
{
    $jumlah = $request->query('jumlah', 5);
    $id_skema = $request->query('id_skema');

    $skema = Skema::findOrFail($id_skema);

    // simpan record baru
    $pembuatan = PembuatanPertanyaan::create([
        'id_skema'         => $id_skema,
        'timer'            => $request->query('timer', 0),
        'jenis_pertanyaan' => 'pmo', // ✅ ini wajib string
        'timescap'         => now(),
    ]);
    

    // ambil kelompok pertama (atau sesuai logic kamu)
    $idKelompok = KelompokPekerjaan::where('id_skema', $id_skema)->value('id_kelompok');

    // redirect ke inputPMO, bawa query param
        return redirect()->route('input.pmo', [
        'id_skema'    => $id_skema,
        'kelompok_id' => $idKelompok,
        'timer'       => $request->query('timer', 30),
        'jumlah'      => $jumlah,
    ]);
}

public function crudPMO($id_pmo)
{
    $pmo = DB::table('pmo')->where('id_pmo', $id_pmo)->first();

    if (!$pmo) {
        return redirect()->back()->with('error', 'PMO tidak ditemukan.');
    }

    $skema = DB::table('skema_sertifikasi')->where('id_skema', $pmo->id_skema)->first();

    $id_pembuatan = request()->query('id_pembuatan');

    $query = DB::table('pmo_pertanyaan')
        ->leftJoin('kelompok_pekerjaan', 'pmo_pertanyaan.id_kelompok', '=', 'kelompok_pekerjaan.id_kelompok')
        ->where('pmo_pertanyaan.id_pmo', $id_pmo)
        ->select('pmo_pertanyaan.*', 'kelompok_pekerjaan.nama_kelompok')
        ->orderBy('pmo_pertanyaan.id_kelompok');

    // ✅ Kalau ada id_pembuatan di query string, filter per set
    // Kalau tidak ada, tampilkan SEMUA termasuk yang NULL
    if ($id_pembuatan) {
        $query->where('pmo_pertanyaan.id_pembuatan_pertanyaan', $id_pembuatan);
    }
    // ❌ HAPUS: tidak ada filter tambahan — NULL ikut tampil semua

    $pertanyaanList = $query->get();

    $unitList     = DB::table('unit_kompetensi')->get();
    $kelompokList = DB::table('kelompok_pekerjaan')->where('id_skema', $pmo->id_skema)->get();

    return view('PMO_crud', compact('pmo', 'skema', 'pertanyaanList', 'unitList', 'kelompokList', 'id_pembuatan'));
}

// Edit pertanyaan PMO
public function editPertanyaanPMO($id_pmo, $id)
{
    // Ambil data PMO
    $pmo = DB::table('pmo')->where('id_pmo', $id_pmo)->first();

    // Ambil pertanyaan yang akan diedit
    $pertanyaan = DB::table('pmo_pertanyaan')->where('id_pmo_pertanyaan', $id)->first();

    if (!$pertanyaan) {
        return redirect()->route('crud', $id_pmo)
                         ->with('error', 'Pertanyaan tidak ditemukan.');
    }

    // Ambil daftar unit dari tabel unit_kompetensi
    $unitList = DB::table('unit_kompetensi')->get();

    // Kirim ke view
    return view('edit_pertanyaan_PMO', [
        'pmo' => $pmo,
        'pertanyaan' => $pertanyaan,
        'unitList' => $unitList,  // ⚡ harus ada ini
    ]);
}

// ================================
// Update Pertanyaan PMO
// ================================
public function updatePertanyaanPMO(Request $request, $id_pmo_pertanyaan)
{
    $request->validate([
        'pertanyaan' => 'required|string',
        'deskripsi_pertanyaan' => 'nullable|string',
        'id_unit' => 'required|array', // 🔥 ubah jadi array (bisa pilih banyak unit)
        'id_pmo'  => 'required|integer',
    ]);

    $pertanyaan = DB::table('pmo_pertanyaan')
        ->where('id_pmo_pertanyaan', $id_pmo_pertanyaan)
        ->first();

    if (!$pertanyaan) {
        return redirect()->back()->with('error', 'Pertanyaan tidak ditemukan.');
    }

    // simpan data
    DB::table('pmo_pertanyaan')
        ->where('id_pmo_pertanyaan', $id_pmo_pertanyaan)
        ->update([
            'id_unit' => json_encode($request->id_unit), // 🔥 simpan sebagai JSON
            'id_pmo' => $request->id_pmo,
            'pertanyaan' => $request->pertanyaan,
            'deskripsi_pertanyaan' => $request->deskripsi_pertanyaan,
            'updated_at' => now(),
        ]);

    return redirect()->route('pmo.crud', $request->id_pmo)
                     ->with('success', 'Pertanyaan PMO berhasil diperbarui!');
}


// ================================
// Hapus Pertanyaan PMO
// ================================
public function destroyPertanyaanPMO($id_pmo_pertanyaan)
{
    $pertanyaan = DB::table('pmo_pertanyaan')->where('id_pmo_pertanyaan', $id_pmo_pertanyaan)->first();

    if (!$pertanyaan) {
        return redirect()->back()->with('error', 'Pertanyaan tidak ditemukan.');
    }

    DB::table('pmo_pertanyaan')->where('id_pmo_pertanyaan', $id_pmo_pertanyaan)->delete();

    return redirect()->route('pmo.crud', $pertanyaan->id_pmo)->with('success', 'Pertanyaan berhasil dihapus');
}

// ================================
// Simpan Pertanyaan PMO Baru
// ================================

public function storePertanyaanPMO(Request $request, $id_pmo)
{
    $pertanyaanList = $request->input('pertanyaan', []);
    $deskripsiList  = $request->input('deskripsi_pertanyaan', []);
    $unitPerSoal    = $request->input('id_unit', []);
    $id_kelompok    = $request->input('id_kelompok');
    $id_pembuatan   = $request->input('id_pembuatan');
    $timer          = $request->input('timer', 30);
    $judul          = $request->input('judul');

    // ✅ Ambil id_skema dari pmo
    $pmo = DB::table('pmo')->where('id_pmo', $id_pmo)->first();

    // Cek dulu apakah ada soal yang valid sebelum buat pembuatan
    $adaSoalValid = false;
    foreach ($pertanyaanList as $i => $pertanyaan) {
        if (!empty(trim($pertanyaan)) && !empty($unitPerSoal[$i] ?? [])) {
            $adaSoalValid = true;
            break;
        }
    }

    if (!$adaSoalValid) {
        return back()->with('error', 'Tidak ada pertanyaan yang tersimpan. Pastikan setiap pertanyaan memilih minimal 1 unit kompetensi.');
    }

    // ✅ Buat pembuatan BARU hanya kalau id_pembuatan kosong (set baru) DAN ada soal valid
    if (!$id_pembuatan && $pmo) {
        $pembuatanBaru = PembuatanPertanyaan::create([
            'id_skema'         => $pmo->id_skema,
            'timer'            => $timer,
            'jenis_pertanyaan' => 'pmo',
            'timescap'         => now(),
           'judul'            => filled($request->input('judul')) ? $request->input('judul') : 'Set Pertanyaan PMO ' . date('Y-m-d H:i:s'),
        ]);
        $id_pembuatan = $pembuatanBaru->id_pembuatan_pertanyaan;
    }

    $saved = 0;
    foreach ($pertanyaanList as $i => $pertanyaan) {
        if (empty(trim($pertanyaan))) continue;

        $selectedUnits = $unitPerSoal[$i] ?? [];
        if (empty($selectedUnits)) continue;

        DB::table('pmo_pertanyaan')->insert([
            'id_pmo'                  => $id_pmo,
            'id_pembuatan_pertanyaan' => $id_pembuatan,
            'id_kelompok'             => $id_kelompok,
            'id_unit'                 => json_encode($selectedUnits),
            'pertanyaan'              => $pertanyaan,
            'deskripsi_pertanyaan'    => $deskripsiList[$i] ?? null,
            
        ]);

        $saved++;
    }

    return redirect()->route('pmo.crud', ['id_pmo' => $id_pmo, 'id_pembuatan' => $id_pembuatan])
                     ->with('success', "{$saved} pertanyaan PMO berhasil disimpan.");
}

    // ================================
    // Simpan Tanggapan PMO
    // ================================
    public function tanggapanPMO(Request $request, $id_pmo_pertanyaan)
    {
        $request->validate([
            'id_pmo' => 'required|exists:pmo,id_pmo',
            'tanggapan' => 'required|string',
            'pencapaian' => 'nullable|string',
        ]);

        DB::table('pmo_tanggapan')->updateOrInsert(
            ['id_pmo_pertanyaan' => $id_pmo_pertanyaan, 'id_pmo' => $request->id_pmo],
            [
                'tanggapan' => $request->tanggapan,
                'pencapaian' => $request->pencapaian,
                'updated_at' => now()
            ]
        );

        return back()->with('success', 'Tanggapan berhasil disimpan');
    }

    // ================================
    // Simpan Persetujuan PMO
    // ================================
    public function persetujuanPMO(Request $request, $id_pmo)
    {
        $request->validate([
            'tgl_ttd_asesi' => 'nullable|date',
            'ttd_asesi' => 'nullable|string',
            'tgl_ttd_asesor' => 'nullable|date',
            'ttd_asesor' => 'nullable|string',
        ]);

        DB::table('pmo_persetujuan')->updateOrInsert(
            ['id_pmo' => $id_pmo],
            [
                'tgl_ttd_asesi' => $request->tgl_ttd_asesi,
                'ttd_asesi' => $request->ttd_asesi,
                'tgl_ttd_asesor' => $request->tgl_ttd_asesor,
                'ttd_asesor' => $request->ttd_asesor,
                'updated_at' => now()
            ]
        );

        return back()->with('success', 'Persetujuan PMO berhasil disimpan');
    }

    // ================================
    // Tampilkan Pembuatan Pertanyaan PMO
    // ================================
    public function pertanyaanPMO($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    // ✅ Ambil hanya id_pembuatan yang punya soal di pmo_pertanyaan untuk skema ini
    $pmo = DB::table('pmo')->where('id_skema', $id_skema)->latest('id_pmo')->first();

    $idPunyaSoal = collect();
    if ($pmo) {
        $idPunyaSoal = DB::table('pmo_pertanyaan')
            ->where('id_pmo', $pmo->id_pmo)
            ->whereNotNull('id_pembuatan_pertanyaan')
            ->pluck('id_pembuatan_pertanyaan')
            ->unique();
    }

    $pembuatanList = PembuatanPertanyaan::whereIn('id_pembuatan_pertanyaan', $idPunyaSoal)
                                        ->orderByDesc('id_pembuatan_pertanyaan')
                                        ->get();

    return view('PMO', compact('skema', 'pembuatanList'));
}
    // ================================
    // Tampilkan Jawaban PMO
    // ================================
    public function jawabanPMO($id_skema, $id_pembuatan)
    {
        $skema = Skema::findOrFail($id_skema);

        $pembuatanList = PembuatanPertanyaan::where('id_skema', $id_skema)
                                            ->where('jenis_pertanyaan', 'pmo')
                                            ->get();

        $pertanyaan = Pertanyaan::where('id_pembuatan_pertanyaan', $id_pembuatan)->get();

        $kelompok = KelompokPekerjaan::with('unitKompetensi')
                    ->where('id_skema', $id_skema)
                    ->get();

        $unitList = DB::table('unit_kompetensi')->get();

        $soalPerKelompok = collect();
        if ($id_pembuatan) {
            $soalPerKelompok = DB::table('pmo_pertanyaan')
                ->where('id_pembuatan_pertanyaan', $id_pembuatan)
                ->get()
                ->groupBy('id_kelompok');
        }

        $timer = $pembuatanList->first()->timer ?? 0;

        return view('jawaban_kelompok_PMO', 
        compact(
        'skema', 
        'pembuatanList',
        'pertanyaan', 
        'kelompok', 
        'timer', 
        'soalPerKelompok',
        'unitList' ));
    }

    // ================================
    // Simpan Jawaban PMO
    // ================================
public function simpanJawabanPMO(Request $request, $id_skema, $id_pembuatan, $id_asesi)
{
    $jawaban = $request->input('jawaban', []);

    foreach($jawaban as $id_pmo_pertanyaan => $isi) {
        $pmopertanyaan = DB::table('pmo_pertanyaan')
            ->where('id_pmo_pertanyaan', $id_pmo_pertanyaan)
            ->first();

        if (!$pmopertanyaan) continue;

        DB::table('pmo_tanggapan')->updateOrInsert(
            ['id_pmo_pertanyaan' => $id_pmo_pertanyaan],
            [
                'id_pmo'    => $pmopertanyaan->id_pmo,
                'id_unit'   => json_decode($pmopertanyaan->id_unit, true)[0] ?? null,
                'tanggapan' => $isi,
            ]
        );
    }

    // ✅ Redirect ke halaman TTD asesi
    return redirect()->route('tanda.tangan.asesmen', [
        'id_skema'                => $id_skema,
        'id_pembuatan_pertanyaan' => $id_pembuatan,
    ])->with('success', 'Jawaban berhasil disimpan.');
}

public function tampilJawabanPMO($id_skema, $id_pembuatan)
{
    $skema = Skema::findOrFail($id_skema);
    $pembuatan = PembuatanPertanyaan::findOrFail($id_pembuatan);
    $kelompok = KelompokPekerjaan::with('unitKompetensi')->where('id_skema', $id_skema)->get();
    $timer = $pembuatan->timer ?? 30;

    // ✅ Ambil id_pmo berdasarkan id_skema
    $pmo = DB::table('pmo')->where('id_skema', $id_skema)->first();

    if (!$pmo) {
        // Kalau belum ada PMO untuk skema ini, buat dulu
        $id_asesor = \App\Models\Asesor::where('user_id', Auth::id())->value('id_asesor');
        $pmo = (object) ['id_pmo' => DB::table('pmo')->insertGetId([
            'id_skema'   => $id_skema,
            'id_tuk'     => 1,
            'id_asesor'  => $id_asesor,
        ])];
    }

    $pertanyaan = DB::table('pmo_pertanyaan')
        ->where('id_pmo', $pmo->id_pmo)
        ->get();

    return view('jawaban_PMO', compact('skema', 'kelompok', 'pertanyaan', 'pembuatan', 'timer'));
}

public function pertanyaanPMOKelompok(Request $request, $id_skema, $id_pembuatan = null)
{
    $skema    = Skema::findOrFail($id_skema);
    $timer    = $request->query('timer', 30);
    $id_pmo   = $request->query('id_pmo');
    $baru     = $request->query('baru', 0);
    $judul    = $request->query('judul'); // ✅ ambil judul dari URL

    if (!$id_pembuatan) {
        $id_pembuatan = $request->query('id_pembuatan');
    }

    if ($baru) {
        // ✅ JANGAN buat pembuatan di sini — buat nanti saat soal disimpan
        $pembuatan    = null;
        $id_pembuatan = null;
    } elseif ($id_pembuatan) {
        $pembuatan = PembuatanPertanyaan::find($id_pembuatan);
    } else {
        $pembuatan    = null;
        $id_pembuatan = null;
    }

    $kelompok = KelompokPekerjaan::with('unitKompetensi')
                ->where('id_skema', $id_skema)
                ->get();

    $soalPerKelompok = collect();
    if ($id_pembuatan) {
        $soalPerKelompok = DB::table('pmo_pertanyaan')
            ->where('id_pembuatan_pertanyaan', $id_pembuatan)
            ->get()
            ->groupBy('id_kelompok');
    }

    $unitList = DB::table('unit_kompetensi')->get();

    return view('kelompok_pekerjaan_PMO', [
        'skema'        => $skema,
        'kelompok'     => $kelompok,
        'timer'        => $timer,
        'judul'        => $judul,   
        'id_pembuatan' => $id_pembuatan,
        'id_pmo'       => $id_pmo,
        'pembuatan'    => $pembuatan,
        'baru'         => $baru, 
        'soalPerKelompok' => $soalPerKelompok,
        'unitList'     => $unitList,
    ]);
}

public function hasilKelompokPMO($id_skema)
{
    $skema = Skema::findOrFail($id_skema);
    $pmo = DB::table('pmo')->where('id_skema', $id_skema)->latest('id_pmo')->first();
    $idPunyaSoal = $pmo
        ? DB::table('pmo_pertanyaan')->where('id_pmo', $pmo->id_pmo)->whereNotNull('id_pembuatan_pertanyaan')->pluck('id_pembuatan_pertanyaan')->unique()
        : collect();
    $pembuatanList = PembuatanPertanyaan::whereIn('id_pembuatan_pertanyaan', $idPunyaSoal)->orderByDesc('id_pembuatan_pertanyaan')->get();
    $kelompok = KelompokPekerjaan::with('unitKompetensi')->where('id_skema', $id_skema)->get();
    return view('PMO.hasil_kelompok_PMO', compact('skema', 'pembuatanList', 'kelompok'));
}

public function inputJawabanPMO($id_skema, $id_pembuatan, $id_kelompok, $id_asesi)
{
    $skema     = Skema::findOrFail($id_skema);
    $pembuatan = PembuatanPertanyaan::findOrFail($id_pembuatan);
    $kelompok  = KelompokPekerjaan::find($id_kelompok);
    $asesi     = DB::table('asesi')->where('id_asesi', $id_asesi)->first();
    $pertanyaan = DB::table('pmo_pertanyaan')
        ->leftJoin('pmo_tanggapan', 'pmo_pertanyaan.id_pmo_pertanyaan', '=', 'pmo_tanggapan.id_pmo_pertanyaan')
        ->where('pmo_pertanyaan.id_pembuatan_pertanyaan', $id_pembuatan)
        ->where('pmo_pertanyaan.id_kelompok', $id_kelompok)
        ->select('pmo_pertanyaan.*', 'pmo_tanggapan.tanggapan')
        ->get();
    $unitList = DB::table('unit_kompetensi')->get();
    return view('PMO.input_jawaban_PMO', compact('skema', 'pembuatan', 'kelompok', 'asesi', 'pertanyaan', 'unitList'));
}

public function pilihAsesiPMO($id_skema, $id_pembuatan, $id_kelompok)
{
    $skema     = Skema::findOrFail($id_skema);
    $pembuatan = PembuatanPertanyaan::findOrFail($id_pembuatan);
    $kelompok  = KelompokPekerjaan::findOrFail($id_kelompok);

    $id_asesor = Asesor::where('user_id', Auth::id())->value('id_asesor');

    $asesiList = DB::table('asesi')
        ->where('asesor_id', $id_asesor)
        ->orderBy('nama_lengkap')
        ->get();

    return view('PMO.pilih_asesi_PMO', compact('skema', 'pembuatan', 'kelompok', 'asesiList'));
}

public function inputPMO(Request $request, $id_skema)
{
    $timer              = $request->query('timer', 30);
    $kelompok_id        = $request->query('kelompok_id');
    $jumlah             = $request->query('jumlah');
    $id_pmo_param       = $request->query('id_pmo');
    $id_pembuatan_param = $request->query('id_pembuatan');
    $id_unit_param      = $request->query('id_unit');

    $id_asesor = Asesor::where('user_id', Auth::id())->value('id_asesor');

    // ✅ Pakai PMO dari URL kalau ada, kalau tidak ambil yang sudah ada (latest), kalau belum ada baru buat
    if ($id_pmo_param) {
        $pmo = PMO::where('id_pmo', $id_pmo_param)->first();
    } else {
        $pmo = PMO::where('id_skema', $id_skema)->latest('id_pmo')->first();
    }

   if (!$pmo) {
    $skemaData = DB::table('skema_sertifikasi')->where('id_skema', $id_skema)->first();

    $id_unit = DB::table('unit_kompetensi')
        ->join('hasil_asesmen', 'unit_kompetensi.id_unit', '=', 'hasil_asesmen.id_unit')
        ->where('hasil_asesmen.id_kelompok', $kelompok_id)
        ->value('unit_kompetensi.id_unit');

    // ✅ Ambil id_asesi dari hasil_asesmen berdasarkan kelompok_id
    $id_asesi = DB::table('hasil_asesmen')
        ->where('id_kelompok', $kelompok_id)
        ->whereNotNull('id_asesi')
        ->value('id_asesi');

    if (!$id_asesi) {
        return back()->with('error', 'Tidak ada asesi ditemukan untuk kelompok ini.');
            if (!$pmo) {
        $pmo = PMO::create([
            'id_skema'   => $id_skema,
            'id_tuk'     => 1,
            'id_asesor'  => $id_asesor,
            'id_kuk'     => 1,
                    'id_asesi'   => 1,   // default sementara

        ]);
    }

    $pmo = PMO::create([
        'id_skema'  => $id_skema,
        'id_unit'   => $id_unit ?? 1,
        'id_tuk'    => $skemaData->id_tuk ?? 1,
        'id_kuk'    => $skemaData->id_kuk ?? 1,
        'id_asesor' => $id_asesor,
        'id_asesi'  => $id_asesi, // ✅ dari hasil_asesmen
    ]);
}

    $unitKompetensi = DB::table('unit_kompetensi')
    ->join('hasil_asesmen', 'unit_kompetensi.id_unit', '=', 'hasil_asesmen.id_unit')
    ->where('hasil_asesmen.id_kelompok', $kelompok_id)
    ->select('unit_kompetensi.*')
    ->distinct()
    ->get();

    $kelompok = $kelompok_id ? KelompokPekerjaan::find($kelompok_id) : null;

    return view('input_PMO', [
    'skema'          => Skema::findOrFail($id_skema),
    'unitKompetensi' => $unitKompetensi,
    'timer'          => $timer,
    'id_pmo'         => $pmo->id_pmo,
    'jumlah'         => $jumlah,
    'kelompok'       => $kelompok,
    'id_pembuatan'   => $id_pembuatan_param,
    'judul'          => $request->query('judul', ''), // ✅ tambah ini
]);
}
}

public function destroySetPMO($id_pembuatan)
{
    // Hapus semua soal dalam set ini
    DB::table('pmo_pertanyaan')
        ->where('id_pembuatan_pertanyaan', $id_pembuatan)
        ->delete();

    // Hapus record pembuatan
    PembuatanPertanyaan::findOrFail($id_pembuatan)->delete();

    return back()->with('success', 'Set pertanyaan berhasil dihapus.');
}

public function dataPesertaUji()
{
    $user = Auth::user();
    $asesi = DB::table('asesi')->where('nama_lengkap', $user->name)->first();

    if (!$asesi) {
        return view('peserta_uji', ['dataPeserta' => collect(), 'rekap' => collect()]);
    }

    // ambil semua jawaban peserta
    $dataPeserta = DB::table('jawaban_asesmen as ja')
        ->join('asesi as a', 'ja.id_asesi', '=', 'a.id_asesi')
        ->join('skema_sertifikasi as s', 'ja.id_skema', '=', 's.id_skema')
        ->join('pertanyaan as p', 'ja.id_pertanyaan', '=', 'p.id_pertanyaan')
        ->leftJoin('opsi_jawaban as o', 'ja.jawaban_opsi', '=', 'o.id_opsi')
        ->select(
            'ja.id_jawaban',
            's.nama_skema',
            'p.isi_pertanyaan',
            'p.jenis_pertanyaan',
            'ja.jawaban_text',
            'o.isi_opsi',
            'ja.pencapaian'
        )
        ->where('ja.id_asesi', $asesi->id_asesi)
        ->get();

    // buat rekap per skema & jenis pertanyaan
    $rekap = $dataPeserta
        ->groupBy(fn($item) => $item->nama_skema . '|' . $item->jenis_pertanyaan)
        ->map(function ($group) {
            $skema = $group->first()->nama_skema;
            $jenis = $group->first()->jenis_pertanyaan;

            $dinilai = $group->whereNotNull('pencapaian');
            $total = $dinilai->count();
            $benar = $dinilai->where('pencapaian', 1)->count();
            $salah = $dinilai->where('pencapaian', 0)->count();

            return [
                'skema'      => $skema,
                'jenis'      => $jenis,
                'total'      => $total ?: '-',
                'benar'      => $total ? $benar : '-',
                'salah'      => $total ? $salah : '-',
                'persentase' => $total > 0 ? round(($benar / $total) * 100) : null,
            ];
        })
        ->values();

    return view('peserta_uji', compact('dataPeserta', 'rekap'));
}

public function detailJawaban($skema, $jenis)
{
    $user = Auth::user();
    $asesi = DB::table('asesi')->where('nama_lengkap', $user->name)->first();

    if (!$asesi) {
        return view('detail_jawaban', ['dataPeserta' => collect(), 'skema' => $skema, 'jenis' => $jenis]);
    }

    if ($jenis === 'pilihan_ganda') {
        $dataPeserta = DB::table('jawaban_asesmen as ja')
            ->join('asesi as a', 'ja.id_asesi', '=', 'a.id_asesi')
            ->join('skema_sertifikasi as s', 'ja.id_skema', '=', 's.id_skema')
            ->join('pertanyaan as p', 'ja.id_pertanyaan', '=', 'p.id_pertanyaan')
            ->leftJoin('opsi_jawaban as o', 'ja.jawaban_opsi', '=', 'o.id_opsi')
            ->select(
                'ja.id_jawaban',
                's.nama_skema',
                'p.id_pertanyaan',
                'p.isi_pertanyaan',
                'p.file_path',
                'p.file_type',
                'p.jenis_pertanyaan',
                'ja.jawaban_text',
                'ja.jawaban_opsi',
                'o.isi_opsi as jawaban_opsi_isi',
                'o.id_opsi as jawaban_opsi_id',
                'ja.pencapaian'
            )
            ->where('ja.id_asesi', $asesi->id_asesi)
            ->where('s.nama_skema', $skema)
            ->where('p.jenis_pertanyaan', $jenis)
            ->get();

        // Ambil semua opsi untuk setiap pertanyaan
        foreach ($dataPeserta as $peserta) {
            $peserta->semua_opsi = DB::table('opsi_jawaban')
                ->where('id_pertanyaan', $peserta->id_pertanyaan)
                ->select('id_opsi', 'kode_opsi', 'isi_opsi', 'benar')
                ->get();
        }
    } else {
        $dataPeserta = DB::table('jawaban_asesmen as ja')
            ->join('asesi as a', 'ja.id_asesi', '=', 'a.id_asesi')
            ->join('skema_sertifikasi as s', 'ja.id_skema', '=', 's.id_skema')
            ->join('pertanyaan as p', 'ja.id_pertanyaan', '=', 'p.id_pertanyaan')
            ->leftJoin('opsi_jawaban as o', 'ja.jawaban_opsi', '=', 'o.id_opsi')
            ->select(
                'ja.id_jawaban',
                's.nama_skema',
                'p.id_pertanyaan',
                'p.isi_pertanyaan',
                'p.file_path',
                'p.file_type',
                'p.jenis_pertanyaan',
                'ja.jawaban_text',
                'o.isi_opsi',
                'ja.pencapaian'
            )
            ->where('ja.id_asesi', $asesi->id_asesi)
            ->where('s.nama_skema', $skema)
            ->where('p.jenis_pertanyaan', $jenis)
            ->get();
    }

    return view('detail_jawaban', compact('dataPeserta', 'skema', 'jenis'));
}
}

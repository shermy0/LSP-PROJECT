<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\OpsiJawaban;
use App\Models\Users;
use App\Models\Skema;
use App\Models\Asesor;
use App\Models\kelompokPekerjaan;
use App\Models\PembuatanPertanyaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

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
    ]);

    $id_skema    = $request->id_skema;
    $id_asesor   = $request->id_asesor;
    $id_kelompok = $request->id_kelompok;
    $timer       = $request->timer;

    // 🔹 Cek apakah ini mode Lanjutkan (edit) atau Selanjutnya (baru)
    if ($request->filled('id_pembuatan')) {
        // Mode LANJUTKAN → update record yang ada
        $pembuatan = PembuatanPertanyaan::findOrFail($request->id_pembuatan);
        $pembuatan->update([
            'timer'            => $timer,
            'timescap'         => now(),
            'jenis_pertanyaan' => 'esai',
        ]);
    } else {
        // Mode SELANJUTNYA → buat record baru
        $pembuatan = PembuatanPertanyaan::create([
            'id_skema'         => $id_skema,
            'timer'            => $timer,
            'timescap'         => now(),
            'jenis_pertanyaan' => 'esai',
        ]);
    }

    // 🔹 Simpan pertanyaan esai
    foreach ($request->isi_pertanyaan as $key => $isi) {
        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_skema = $id_skema;
        $pertanyaan->id_kelompok = $id_kelompok;
        $pertanyaan->id_asesor = $id_asesor;
        $pertanyaan->id_pembuatan_pertanyaan = $pembuatan->id_pembuatan_pertanyaan;
        $pertanyaan->jenis_pertanyaan = 'esai';
        $pertanyaan->isi_pertanyaan = $isi;
        $pertanyaan->kunci_jawaban = $request->kunci_jawaban[$key] ?? null;

        if ($request->hasFile("file.$key")) {
            $file = $request->file("file.$key");
            $filePath = $file->store('uploads/pertanyaan', 'public');
            $pertanyaan->file_path = $filePath;
            $pertanyaan->file_type = $file->getClientOriginalExtension();
        }

        $pertanyaan->save();
    }

    return redirect()->route('esai.crud', [
        'id_skema'    => $id_skema,
        'id_kelompok' => $id_kelompok
    ])->with('success', 'Semua pertanyaan esai berhasil disimpan dengan timer!');
}



    public function crudEsai($id_skema, $id_kelompok)
{
    $skema = Skema::findOrFail($id_skema);

    $pertanyaan = Pertanyaan::where('jenis_pertanyaan', 'esai')
                            ->where('id_skema', $id_skema)
                            ->where('id_kelompok', $id_kelompok) // ✅ filter kelompok juga
                            ->get();
    
    $pembuatan_pertanyaan = PembuatanPertanyaan::find($pertanyaan->first()->id_pembuatan_pertanyaan);

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
    
    return view('esai_crud', compact('pertanyaan', 'skema', 'id_kelompok', 'pembuatan_pertanyaan', 'asesor'));
}

   public function editEsai($id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);
    $skema = Skema::find($pertanyaan->id_skema);

    return view('input_esai_edit', [
        'pertanyaan' => $pertanyaan,
        'skema'      => $skema,
        'id_skema'   => $pertanyaan->id_skema,
        'id_kelompok'=> $pertanyaan->id_kelompok
    ]);

    
}


    public function updateEsai(Request $request, $id)
{
    $pertanyaan = Pertanyaan::findOrFail($id);

    $request->validate([
        'isi_pertanyaan' => 'required|string',
        'kunci_jawaban'  => 'nullable|string',
        'file'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
    ]);

    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $file = $request->file('file');
        $filePath = $file->store('uploads/pertanyaan', 'public');
        $pertanyaan->file_path = $filePath;
        $pertanyaan->file_type = $file->getClientOriginalExtension();
    }

    $pertanyaan->isi_pertanyaan = $request->isi_pertanyaan;
    $pertanyaan->kunci_jawaban  = $request->kunci_jawaban;
    $pertanyaan->save();

    return redirect()->route('esai.crud', [
        'id_skema'    => $pertanyaan->id_skema,
        'id_kelompok' => $pertanyaan->id_kelompok
    ])->with('success', 'Pertanyaan esai berhasil diupdate!');
}

    public function destroyEsai($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $id_skema   = $pertanyaan->id_skema;

        if ($pertanyaan->file_path && \Storage::disk('public')->exists($pertanyaan->file_path)) {
            \Storage::disk('public')->delete($pertanyaan->file_path);
        }

        $pertanyaan->delete();

       return redirect()->route('esai.crud', [
    'id_skema'   => $id_skema,
    'id_kelompok'=> $pertanyaan->id_kelompok
])->with('success', 'Pertanyaan esai berhasil dihapus!');
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
        'timer' => 'required|integer|min:1'
    ]);

    $jumlah = $request->query('jumlah', 5);
    $id_skema = $request->query('id_skema');
    $id_kelompok = $request->query('id_kelompok');
    $timer = $request->query('timer', 30);

    $skema = Skema::findOrFail($id_skema);
    $kelompok = KelompokPekerjaan::findOrFail($id_kelompok);

    // Log untuk debugging
    \Log::info('CreatePG called', [
        'jumlah' => $jumlah,
        'id_skema' => $id_skema,
        'id_kelompok' => $id_kelompok,
        'timer' => $timer
    ]);

    return view('pertanyaan.input_pg', [
        'skema' => $skema,
        'kelompok' => $kelompok,
        'jumlah' => $jumlah,
        'timer' => $timer,
        'id_pembuatan_pertanyaan' => $request->query('id_pembuatan_pertanyaan')
    ]);
}

public function storePG(Request $request)
{
    \Log::info('=== StorePG masuk ===');

    // Validasi
    try {
        $validated = $request->validate([
            'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
            'id_kelompok' => 'required|exists:kelompok_pekerjaan,id_kelompok',
            'id_pembuatan_pertanyaan' => 'nullable|exists:pembuatan_pertanyaan,id_pembuatan_pertanyaan',
            'timer' => 'required|integer|min:1',
            'isi_pertanyaan' => 'required|array|min:1',
            'isi_pertanyaan.*' => 'required|string|min:5',
            'jenis_opsi' => 'required|array',
            'jenis_opsi.*' => 'required|array|min:5',
            'jenis_opsi.*.*' => 'required|string|in:text,gambar',
            'opsi_text' => 'required|array',
            'opsi_text.*' => 'required|array',
            'opsi_text.*.*' => 'nullable|string',
            'opsi_gambar' => 'required|array',
            'opsi_gambar.*' => 'required|array',
            'opsi_gambar.*.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'kunci_jawaban' => 'required|array',
            'kunci_jawaban.*' => 'required|string|in:A,B,C,D,E',
            'file.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        ]);
        \Log::info('Validasi sukses', $validated);
    } catch (\Illuminate\Validation\ValidationException $e) {
        \Log::error('Validasi gagal', $e->errors());
        return back()->withErrors($e->errors())->withInput();
    }

    DB::beginTransaction();
    try {
        \Log::info('Mulai simpan pembuatan pertanyaan');

        if ($request->filled('id_pembuatan_pertanyaan')) {
            $pembuatanId = $request->id_pembuatan_pertanyaan;
            PembuatanPertanyaan::where('id_pembuatan_pertanyaan', $pembuatanId)
                ->update(['timer' => $request->timer]);
            \Log::info("Update pembuatan_pertanyaan id=$pembuatanId");
        } else {
            $pembuatan = PembuatanPertanyaan::create([
                'id_skema' => $request->id_skema,
                'timer'    => $request->timer,
                'timescap' => now(),
            ]);
            $pembuatanId = $pembuatan->id_pembuatan_pertanyaan;
            \Log::info("Insert pembuatan_pertanyaan baru id=$pembuatanId");
        }

        $id_asesor = auth()->user()->asesor->id_asesor;

        foreach ($request->isi_pertanyaan as $i => $isi) {
            if (empty(trim($isi))) continue;

            \Log::info("Proses pertanyaan ke-$i: $isi");

            $filePath = null;
            $fileType = null;
            if ($request->hasFile("file.$i") && $request->file("file.$i")->isValid()) {
                $file = $request->file("file.$i");
                $filePath = $file->store("uploads/pertanyaan", "public");
                $fileType = $file->getClientOriginalExtension();
                \Log::info("File diupload untuk pertanyaan ke-$i: $filePath");
            }

            $pertanyaan = Pertanyaan::create([
                'id_skema' => $request->id_skema,
                'id_kelompok' => $request->id_kelompok,
                'id_pembuatan_pertanyaan' => $pembuatanId,
                'id_asesor' => $id_asesor,
                'jenis_pertanyaan' => 'pilihan_ganda',
                'isi_pertanyaan' => $isi,
                'file_path' => $filePath,
                'file_type' => $fileType,
                'kunci_jawaban' => $request->kunci_jawaban[$i],
            ]);

            \Log::info("Pertanyaan tersimpan id={$pertanyaan->id_pertanyaan}");

            // Simpan opsi jawaban
            if (isset($request->jenis_opsi[$i])) {
                foreach ($request->jenis_opsi[$i] as $j => $jenis) {
                    $kode = chr(65 + $j);
                    $isiOpsi = null;

                    if ($jenis === 'text') {
                        // Simpan teks langsung
                        $isiOpsi = $request->opsi_text[$i][$j] ?? '';
                    } elseif ($jenis === 'gambar') {
                        // Simpan gambar sebagai file dan simpan path-nya
                        if ($request->hasFile("opsi_gambar.$i.$j") && $request->file("opsi_gambar.$i.$j")->isValid()) {
                            $fileOpsi = $request->file("opsi_gambar.$i.$j");
                            
                            // Generate nama file yang singkat
                            $timestamp = now()->format('YmdHis');
                            $fileName = "opsi_{$pertanyaan->id_pertanyaan}_{$kode}_{$timestamp}.{$fileOpsi->getClientOriginalExtension()}";
                            
                            $filePath = $fileOpsi->storeAs("uploads/opsi_jawaban", $fileName, "public");
                            $isiOpsi = $filePath; // Simpan path file saja
                            
                            \Log::info("Gambar opsi disimpan: $filePath");
                        }
                    }

                    if (!empty($isiOpsi)) {
                        OpsiJawaban::create([
                            'id_pertanyaan' => $pertanyaan->id_pertanyaan,
                            'kode_opsi' => $kode,
                            'isi_opsi' => $isiOpsi,
                            'benar' => ($request->kunci_jawaban[$i] === $kode) ? 1 : 0,
                        ]);
                        \Log::info("Opsi $kode ($jenis) disimpan untuk pertanyaan {$pertanyaan->id_pertanyaan}");
                    }
                }
            }
        }

        DB::commit();
        \Log::info('StorePG sukses total');

        return redirect()->route('pg.crud', [
            'id_skema' => $request->id_skema,
            'id_kelompok' => $request->id_kelompok
        ])->with('success', 'Pertanyaan pilihan ganda berhasil disimpan!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('StorePG error: ' . $e->getMessage());
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
    \Log::info('=== UpdatePG Dimulai ===');
    \Log::info('Request Data:', $request->all());
    \Log::info('Files:', $request->file() ?: []);

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
        $timer = $request->query('timer');
    
        $kelompok = KelompokPekerjaan::with(['unitKompetensi' => function ($q) use ($id_skema) {
            $q->where('unit_kompetensi.id_skema', $id_skema);
        }])->where('id_skema', $id_skema)->get();
    
        $skema = Skema::find($id_skema);
    
        // Tentukan view berdasarkan jenis
        if ($jenis === 'esai') {
            return view('kelompok_pekerjaan_essai', compact('kelompok', 'timer', 'id_skema', 'jenis', 'skema'));
        } elseif ($jenis === 'pilihan_ganda') {
            return view('kelompok_pekerjaan_pg', compact('kelompok', 'timer', 'id_skema', 'jenis', 'skema'));
        } else {
            return view('kelompok_pekerjaan_lisan', compact('kelompok', 'timer', 'id_skema', 'jenis', 'skema'));
        }
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
    
};
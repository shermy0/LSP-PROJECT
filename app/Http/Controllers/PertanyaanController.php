<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
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
    // FORM LISAN
    // ================================
    public function createLisan(Request $request)
    {
        $jumlah   = $request->query('jumlah', 5); 
        $id_skema = $request->query('id_skema');

        $skema = Skema::findOrFail($id_skema);
        return view('input_lisan', compact('skema', 'jumlah'));
    }

        public function storeLisan(Request $request)
    {
        $request->validate([
            'id_skema'           => 'required|integer',
            'id_asesor'          => 'required|integer',
            'isi_pertanyaan.*'   => 'required|string',
            'kunci_jawaban.*'    => 'nullable|string',
        ]);

        $id_skema  = $request->id_skema;
        $id_asesor = $request->id_asesor;

        foreach ($request->isi_pertanyaan as $key => $isi) {
        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_skema         = $id_skema;
        $pertanyaan->id_asesor        = $id_asesor; // ambil dari form request
        $pertanyaan->jenis_pertanyaan = 'lisan';
        $pertanyaan->isi_pertanyaan   = $isi;
        $pertanyaan->kunci_jawaban    = $request->kunci_jawaban[$key] ?? null;
        $pertanyaan->save();
        }

        return redirect()->route('pertanyaan.index')
                         ->with('success', 'Pertanyaan lisan berhasil ditambahkan!');
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
        'id_kelompok'      => 'required|integer', // 🔹
        'isi_pertanyaan.*' => 'required|string',
        'kunci_jawaban.*'  => 'nullable|string',
        'file.*'           => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        'timer'            => 'required|integer',
    ]);

    $id_skema    = $request->id_skema;
    $id_asesor   = $request->id_asesor;
    $id_kelompok = $request->id_kelompok; // 🔹
    $timer       = $request->timer;

    // Simpan ke tabel pembuatan_pertanyaan
    $pembuatan = PembuatanPertanyaan::create([
        'id_skema' => $id_skema,
        'timer'    => $timer,
        'timescap' => now(),
    ]);

    // Simpan pertanyaan esai
    foreach ($request->isi_pertanyaan as $key => $isi) {
        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_skema = $id_skema;
        $pertanyaan->id_kelompok = $id_kelompok; // 🔹 masuk sini
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
    'id_skema'   => $id_skema,
    'id_kelompok'=> $id_kelompok
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
        $jumlah   = $request->get('jumlah', 5); 
        $id_unit  = 1;
        $id_skema = 1;

        return view('pertanyaan.input_pg', compact('id_unit', 'id_skema', 'jumlah'));
    }

    public function storePG(Request $request)
    {
        $request->validate([
            'id_unit'        => 'required|integer',
            'id_skema'       => 'required|integer',
            'id_asesor'      => 'required|integer',
            'isi_pertanyaan' => 'required|array|min:1',
            'opsi'           => 'required|array',
            'kunci_jawaban'  => 'required|array',
        ]);

        foreach ($request->isi_pertanyaan as $index => $isi) {
            Pertanyaan::create([
                'id_unit'          => $request->id_unit,
                'id_skema'         => $request->id_skema,
                'id_asesor'        => $request->id_asesor,
                'jenis_pertanyaan' => 'pilihan_ganda',
                'isi_pertanyaan'   => $isi,
                'kunci_jawaban'    => $request->kunci_jawaban[$index] ?? null,
            ]);

            // Kalau mau simpan opsi ke tabel opsi_jawaban, bisa ditambahkan di sini
        }

        return redirect()->route('pertanyaan.index')
                         ->with('success', 'Pertanyaan PG berhasil ditambahkan!');
    }
public function kelompokPekerjaan(Request $request, $id_skema, $jenis = 'lisan')
{
    $timer = $request->query('timer');

    $kelompok = \App\Models\KelompokPekerjaan::with(['unitKompetensi' => function ($q) use ($id_skema) {
        $q->where('unit_kompetensi.id_skema', $id_skema);
    }])->where('id_skema', $id_skema)->get();

    // Tentukan view berdasarkan jenis dari defaults() route
    if ($jenis === 'essai') {
        return view('kelompok_pekerjaan_essai', compact('kelompok', 'timer', 'id_skema'));
    }

    return view('kelompok_pekerjaan_lisan', compact('kelompok', 'timer', 'id_skema'));
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
    
}

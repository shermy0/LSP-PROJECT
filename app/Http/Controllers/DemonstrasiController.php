<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Demonstrasi, MasterTugasDemonstrasi, Skema, KelompokPekerjaan};
use Illuminate\Support\Facades\Storage;

class DemonstrasiController extends Controller
{
    public function index($id_skema)
{
    $skema = Skema::findOrFail($id_skema);

    $demonstrasi = Demonstrasi::where('id_skema', $id_skema)
        ->with('tugas') // relasi ke MasterTugasDemonstrasi
        ->get();

    return view('demonstrasi', compact('skema','demonstrasi'));

}

    public function create(Request $request)
    {
        $skema = Skema::findOrFail($request->id_skema);
        return view('demonstrasi.create', compact('skema'));
    }

    public function store(Request $request)
    {
        $request->validate([
    'id_skema' => 'required|exists:skema_sertifikasi,id_skema',
    'timer'    => 'required|integer|min:1'
]);

$demo = Demonstrasi::create([
    'id_skema' => $request->id_skema,
    'timer'    => $request->timer
]);


        return redirect()->route('pertanyaan.demonstrasi.kelompok',$request->id_skema)
                         ->with('success','Timer demonstrasi disimpan.');
    }

    public function kelompok($id_skema, Request $request)
    {
        $skema = Skema::findOrFail($id_skema);
        $timer = $request->query('timer');
        $kelompok = KelompokPekerjaan::where('id_skema',$id_skema)->get();

       return view('kelompok_pekerjaan_demo', compact('skema','kelompok','timer'));

    }

    public function createTugas(Request $request)
{
    $jumlah      = $request->query('jumlah', 5);
    $id_skema    = $request->query('id_skema');
    $id_kelompok = $request->query('kelompok_id');
    $timer       = $request->query('timer');

    $skema = Skema::findOrFail($id_skema);

    // Cek apakah demonstrasi sudah ada untuk skema ini
    $demo = Demonstrasi::firstOrCreate(
        [
            'id_skema' => $id_skema,
        ],
        [
            'timer' => $timer
        ]
    );

    return view('demonstrasi_create', [
        'skema' => $skema,
        'id_kelompok' => $id_kelompok,
        'jumlah' => $jumlah,
        'timer' => $timer,
        'id_demonstrasi' => $demo->id_demonstrasi // lempar ke view
    ]);
}


 public function storeTugas(Request $request)
{
    $request->validate([
        'id_demonstrasi' => 'required|exists:demonstrasi,id_demonstrasi',
        'id_skema'       => 'required|exists:skema_sertifikasi,id_skema',
        'id_asesor'      => 'required|exists:asesor,id_asesor',
        'id_kelompok'    => 'required|exists:kelompok_pekerjaan,id_kelompok',
        'isi_pertanyaan_demonstrasi.*' => 'required|string',
        'kunci_jawaban.*' => 'nullable|string',
        'deskripsi_pertanyaan.*' => 'nullable|string',
        'file.*' => 'nullable|file|max:2048'
    ]);

    foreach ($request->isi_pertanyaan_demonstrasi as $i => $isi) {
        // ✅ Skip kalau input kosong
        if (empty($isi)) continue;

        $filePath = null;
        $fileType = null;

        if ($request->hasFile("file.$i")) {
            $file = $request->file("file.$i");
            $filePath = $file->store('uploads/demonstrasi', 'public');
            $fileType = $file->getClientOriginalExtension();
        }

      MasterTugasDemonstrasi::create([
    'id_demonstrasi'             => $request->id_demonstrasi,
    'id_skema'                   => $request->id_skema,
    'id_asesor'                  => $request->id_asesor,
    'id_kelompok'                => $request->id_kelompok,
    'isi_pertanyaan_demonstrasi' => $isi, // ✅ penting
    'deskripsi_pertanyaan'       => $request->deskripsi_pertanyaan[$i] ?? null,
    'kunci_jawaban'              => $request->kunci_jawaban[$i] ?? null,
    'file_path'                  => $filePath,
    'file_type'                  => $request->file_type[$i] ?? null,
]);


    }

    return $request->action === 'back'
        ? redirect()->route('demonstrasi.crud', [$request->id_skema, $request->id_kelompok])
                    ->with('success', 'Tugas demonstrasi berhasil disimpan!')
        : back()->with('success', 'Tugas demonstrasi berhasil disimpan!');
}



// 📍 Menampilkan daftar tugas demonstrasi (crud.blade.php)
    public function crud($id_skema, $id_kelompok)
    {
        $skema = Skema::findOrFail($id_skema);
        $tugas = MasterTugasDemonstrasi::where('id_skema', $id_skema)
                               ->where('id_kelompok', $id_kelompok)
                               ->get();


        return view('demonstrasi_crud', compact('skema', 'tugas', 'id_kelompok'));
    }

    // 📍 Form edit tugas demonstrasi (demonstrasi_edit.blade.php)
    public function edit($id)
{
    $tugas = MasterTugasDemonstrasi::findOrFail($id);
    $skema = Skema::findOrFail($tugas->id_skema);

    return view('demonstrasi_edit', compact('tugas', 'skema'));
}

public function update(Request $request, $id)
{
    $tugas = MasterTugasDemonstrasi::findOrFail($id);

    $tugas->update([
        'isi_pertanyaan_demonstrasi' => $request->isi_pertanyaan_demonstrasi,
        'deskripsi_pertanyaan'       => $request->deskripsi_pertanyaan,
        'kunci_jawaban'              => $request->kunci_jawaban,
        'file_type'                  => $request->file_type,
    ]);

    return redirect()->route('demonstrasi.crud', [
        'id_skema'   => $tugas->id_skema,
        'id_kelompok'=> $tugas->id_kelompok
    ])->with('success', 'Tugas demonstrasi berhasil diperbarui!');
}

public function destroy($id)
{
    $tugas = MasterTugasDemonstrasi::findOrFail($id);
    $id_skema = $tugas->id_skema;
    $id_kelompok = $tugas->id_kelompok;

    $tugas->delete();

    return redirect()->route('demonstrasi.crud', [
        'id_skema'   => $id_skema,
        'id_kelompok'=> $id_kelompok
    ])->with('success', 'Tugas demonstrasi berhasil dihapus!');
}
}
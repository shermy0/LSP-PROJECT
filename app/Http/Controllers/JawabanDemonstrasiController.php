<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\{Demonstrasi, MasterTugasDemonstrasi, JawabanDemonstrasi, Asesi};

class JawabanDemonstrasiController extends Controller
{
    public function show($id_skema)
    {
        $user = auth()->user();
        $asesi = Asesi::where('user_id', $user->id)->firstOrFail();

        $demo = Demonstrasi::where('id_skema', $id_skema)->firstOrFail();
        $tugas = MasterTugasDemonstrasi::where('id_demonstrasi', $demo->id_demonstrasi)->get();

        $jawabanSebelumnya = JawabanDemonstrasi::where('id_asesi', $asesi->id_asesi)
        ->where('id_skema', $id_skema)
        ->get()
        ->keyBy('id_tugas');

        return view('demonstrasi.jawab', [
            'id_skema' => $id_skema,
            'id_demonstrasi' => $demo->id_demonstrasi,
            'tugas' => $tugas,
            'timer' => $demo->timer,
            'asesi' => $asesi,
            'jawabanSebelumnya' => $jawabanSebelumnya,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_skema' => 'required',
            'id_demonstrasi' => 'required',
            'jawaban_text' => 'array',
            'jawaban_file.*' => 'nullable|file|max:5120'
        ]);

        $user = auth()->user();
        $asesi = Asesi::where('user_id', $user->id)->firstOrFail();

        foreach ($request->jawaban_text as $id_tugas => $jawaban) {
            $filePath = null;
            if ($request->hasFile("jawaban_file.$id_tugas")) {
                $file = $request->file("jawaban_file.$id_tugas");
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('jawaban_demonstrasi', $fileName, 'public');
            }

            JawabanDemonstrasi::updateOrCreate(
                [
                    'id_tugas' => $id_tugas,
                    'id_asesi' => $asesi->id_asesi,
                    'id_skema' => $request->id_skema
                ],
                [
                    'jawaban_text' => $jawaban,
                    'jawaban_file' => $filePath
                ]
            );
        }

        // Simpan tanda tangan jika ada
        if ($request->filled('ttd_asesi')) {
            $ttdData = preg_replace('#^data:image/\w+;base64,#i', '', $request->ttd_asesi);
            $ttdData = str_replace(' ', '+', $ttdData);
            $imageData = base64_decode($ttdData);

            $namaAsesi = Str::slug($asesi->nama_lengkap, '_');
            $tanggal = $request->tgl_ttd_asesi ?: date('Y-m-d');
            $fileName = 'ttd_asesmen_demonstrasi_'.$namaAsesi . '_' . '_'. $tanggal . '.png';
            $filePath = storage_path('app/public/ttd/' . $fileName);

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            file_put_contents($filePath, $imageData);

            $lastJawaban = JawabanDemonstrasi::where('id_asesi', $asesi->id_asesi)
                ->where('id_skema', $request->id_skema)
                ->orderBy('id_jawaban', 'desc')
                ->first();

            if ($lastJawaban) {
                DB::table('jawaban_demonstrasi_persetujuan')->updateOrInsert(
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

    if ($request->ajax()) {
        return response()->json(['success' => true]);
    }


        return redirect()->route('asesi.dashboard')->with('success', 'Jawaban demonstrasi berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Users;
use App\Models\Skema;
use App\Models\Asesor;
use App\Models\KelompokPekerjaan;
use App\Models\PembuatanPertanyaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PertanyaanController extends Controller
{
    // ================================
    // INDEX & SHOW SKEMA
    // ================================
    public function index()
    {
        $pertanyaan = Pertanyaan::all();
        return view('pertanyaan.index', compact('pertanyaan'));
    }

    public function show($id_skema)
    {
        $skema = Skema::findOrFail($id_skema);

        // Pilih view berdasarkan tipe asesmen
        return match($skema->tipe) {
            'lisan'    => view('formasesmen.lisan', compact('skema')),
            'tertulis' => view('formasesmen.tertulis', compact('skema')),
            default    => view('formasesmen.praktek', compact('skema')),
        };
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
    // CRUD ESAI
    // ================================
    public function createEsai(Request $request)
    {
        $jumlah = $request->query('jumlah', 5);
        $id_skema = $request->query('id_skema');
        $skema = Skema::findOrFail($id_skema);

        return view('input_esai', compact('skema', 'jumlah'));
    }

    public function storeEsai(Request $request)
    {
        $request->validate([
            'id_skema' => 'required|integer',
            'id_asesor' => 'required|integer',
            'id_kelompok' => 'required|integer',
            'isi_pertanyaan.*' => 'required|string',
            'kunci_jawaban.*' => 'nullable|string',
            'file.*' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
            'timer' => 'required|integer',
        ]);

        $pembuatan = PembuatanPertanyaan::create([
            'id_skema' => $request->id_skema,
            'timer' => $request->timer,
            'timescap' => now(),
        ]);

        foreach ($request->isi_pertanyaan as $key => $isi) {
            $pertanyaan = new Pertanyaan();
            $pertanyaan->fill([
                'id_skema' => $request->id_skema,
                'id_asesor' => $request->id_asesor,
                'id_kelompok' => $request->id_kelompok,
                'id_pembuatan_pertanyaan' => $pembuatan->id_pembuatan_pertanyaan,
                'jenis_pertanyaan' => 'esai',
                'isi_pertanyaan' => $isi,
                'kunci_jawaban' => $request->kunci_jawaban[$key] ?? null,
            ]);

            if ($request->hasFile("file.$key")) {
                $file = $request->file("file.$key");
                $pertanyaan->file_path = $file->store('uploads/pertanyaan', 'public');
                $pertanyaan->file_type = $file->getClientOriginalExtension();
            }

            $pertanyaan->save();
        }

        return redirect()->route('esai.crud', [
            'id_skema' => $request->id_skema,
            'id_kelompok' => $request->id_kelompok
        ])->with('success', 'Semua pertanyaan esai berhasil disimpan dengan timer!');
    }

    public function crudEsai($id_skema, $id_kelompok)
    {
        $skema = Skema::findOrFail($id_skema);

        $pertanyaan = Pertanyaan::where('id_skema', $id_skema)
            ->where('id_kelompok', $id_kelompok)
            ->where('jenis_pertanyaan', 'esai')
            ->get();

        $pembuatan_pertanyaan = $pertanyaan->first() 
            ? PembuatanPertanyaan::find($pertanyaan->first()->id_pembuatan_pertanyaan) 
            : null;

        $asesor = DB::table('asesor')
            ->leftJoin('pertanyaan_asesmen_persetujuan', function($join) use ($pembuatan_pertanyaan) {
                $join->on('asesor.id_asesor', '=', 'pertanyaan_asesmen_persetujuan.id_asesor')
                    ->where('pertanyaan_asesmen_persetujuan.id_pembuatan_pertanyaan', $pembuatan_pertanyaan->id_pembuatan_pertanyaan ?? 0);
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

        return view('input_esai_edit', compact('pertanyaan', 'skema'));
    }

    public function updateEsai(Request $request, $id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'isi_pertanyaan' => 'required|string',
            'kunci_jawaban' => 'nullable|string',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,docx,mp3,mp4|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $pertanyaan->file_path = $file->store('uploads/pertanyaan', 'public');
            $pertanyaan->file_type = $file->getClientOriginalExtension();
        }

        $pertanyaan->update([
            'isi_pertanyaan' => $request->isi_pertanyaan,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return redirect()->route('esai.crud', [
            'id_skema' => $pertanyaan->id_skema,
            'id_kelompok' => $pertanyaan->id_kelompok
        ])->with('success', 'Pertanyaan esai berhasil diupdate!');
    }

    public function destroyEsai($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);

        if ($pertanyaan->file_path) {
            Storage::disk('public')->delete($pertanyaan->file_path);
        }

        $id_skema = $pertanyaan->id_skema;
        $id_kelompok = $pertanyaan->id_kelompok;

        $pertanyaan->delete();

        return redirect()->route('esai.crud', [
            'id_skema' => $id_skema,
            'id_kelompok' => $id_kelompok
        ])->with('success', 'Pertanyaan esai berhasil dihapus!');
    }
    
    // ================================
    // KELOMPOK PEKERJAAN
    // ================================
    public function kelompokPekerjaan(Request $request, $id_skema)
    {
        $timer = $request->query('timer');

        $skema = Skema::findOrFail($id_skema);

        // Ambil semua kelompok di skema ini
        $kelompok = KelompokPekerjaan::with(['pertanyaan' => function($q) {
            $q->where('jenis_pertanyaan', 'lisan');
        }])->where('id_skema', $id_skema)->get();

       return view('kelompok_pekerjaan_lisan', compact('skema', 'kelompok', 'timer'));

    }

    // ================================
    // PILIHAN GANDA
    // ================================
    public function createPG(Request $request)
    {
        $jumlah = $request->get('jumlah', 5);
        $id_unit = 1;
        $id_skema = 1;

        return view('pertanyaan.input_pg', compact('id_unit', 'id_skema', 'jumlah'));
    }

    public function storePG(Request $request)
    {
        $request->validate([
            'id_unit' => 'required|integer',
            'id_skema' => 'required|integer',
            'id_asesor' => 'required|integer',
            'isi_pertanyaan' => 'required|array|min:1',
            'opsi' => 'required|array',
            'kunci_jawaban' => 'required|array',
        ]);

        foreach ($request->isi_pertanyaan as $index => $isi) {
            Pertanyaan::create([
                'id_unit' => $request->id_unit,
                'id_skema' => $request->id_skema,
                'id_asesor' => $request->id_asesor,
                'jenis_pertanyaan' => 'pilihan_ganda',
                'isi_pertanyaan' => $isi,
                'kunci_jawaban' => $request->kunci_jawaban[$index] ?? null,
            ]);
        }

        return redirect()->route('pertanyaan.index')
            ->with('success', 'Pertanyaan PG berhasil ditambahkan!');
    }

    // ================================
    // TTD ASESOR
    // ================================
    public function formTTDAsesor($id_skema, $id_pembuatan_pertanyaan)
    {
        $user = auth()->user(); 
        $asesorLogin = Asesor::where('user_id', $user->id)->first();
        $pembuatan_pertanyaan = PembuatanPertanyaan::find($id_pembuatan_pertanyaan);
        $skema = Skema::find($id_skema);

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
            'asesorLogin', 'asesorSudahTTD', 'pembuatan_pertanyaan', 'skema', 'id_skema', 'id_pembuatan_pertanyaan'
        ));
    }

    public function simpanTTDAsesor(Request $request, $id_skema, $id_pembuatan_pertanyaan)
    {
        $validated = $request->validate([
            'id_pembuatan_pertanyaan' => 'required|exists:pembuatan_pertanyaan,id_pembuatan_pertanyaan',
            'id_asesor' => 'required|exists:asesor,id_asesor',
            'tgl_ttd_asesor' => 'required|date',
            'ttd_asesor' => 'required'
        ]);

        $asesor = Asesor::findOrFail($validated['id_asesor']);
        $slugNama = str_replace(' ', '_', strtolower($asesor->nama_asesor));
        $ttdFileName = 'ttd_asesor_pertanyaan_asesmen_persetujuan_' 
            . $slugNama . '_idpembuatan_' . $validated['id_pembuatan_pertanyaan'] . '_' . date('Ymd') . '.png';

        $ttdData = str_replace(['data:image/png;base64,', ' '], ['', '+'], $validated['ttd_asesor']);
        File::put(storage_path('app/public/ttd/' . $ttdFileName), base64_decode($ttdData));

        $existing = DB::table('pertanyaan_asesmen_persetujuan')
            ->where('id_pembuatan_pertanyaan', $validated['id_pembuatan_pertanyaan'])
            ->where('id_asesor', $validated['id_asesor'])
            ->first();

        if ($existing) {
            DB::table('pertanyaan_asesmen_persetujuan')
                ->where('id_pertanyaan_persetujuan', $existing->id_pertanyaan_persetujuan)
                ->update([
                    'tgl_ttd_asesor' => $validated['tgl_ttd_asesor'],
                    'ttd_asesor' => $ttdFileName
                ]);
        } else {
            DB::table('pertanyaan_asesmen_persetujuan')->insert([
                'id_pembuatan_pertanyaan' => $validated['id_pembuatan_pertanyaan'],
                'id_asesor' => $validated['id_asesor'],
                'tgl_ttd_asesor' => $validated['tgl_ttd_asesor'],
                'ttd_asesor' => $ttdFileName
            ]);
        }

        return redirect()->route('tanda.tangan.asesmen', [$id_skema, $id_pembuatan_pertanyaan])
            ->with('success', 'TTD Asesor berhasil disimpan!');
    }
}

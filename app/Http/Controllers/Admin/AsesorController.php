<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asesor;
use App\Models\Jurusan;
use App\Models\SkemaSertifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AsesorCredentialsMail;

class AsesorController extends Controller
{
    public function index()
    {
        $asesor = Asesor::with(['jurusan', 'skemas'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        $daftarSkema = SkemaSertifikasi::all();

        return view('admin.asesor.index', compact('asesor', 'daftarSkema'));
    }

    public function show($id)
    {
        $asesor = Asesor::with(['jurusan', 'skemas'])->findOrFail($id);
        return view('admin.asesor.show', compact('asesor'));
    }

    public function store(Request $request)
    {
        // Validasi: email wajib dan unik
        $validator = Validator::make($request->all(), [
            'nama_asesor'   => 'required|string|max:255',
            'nip'           => 'nullable|string|max:100|unique:asesor,nip',
            'email'         => 'required|email|max:255|unique:users,email|unique:asesor,email',
            'telepon'       => 'nullable|string|max:30',
            'id_jurusan'    => 'nullable|exists:jurusan,id_jurusan',
            'no_registrasi' => 'nullable|string|max:100|unique:asesor,no_registrasi',
            'skema_ids'     => 'nullable|array',
            'skema_ids.*'   => 'exists:skema_sertifikasi,id_skema',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Generate password random (8 karakter)
            $plainPassword = Str::random(8);

            // Buat user account (role asesor)
            $user = User::create([
                'name'     => $request->nama_asesor,
                'email'    => $request->email,
                'password' => Hash::make($plainPassword),
                'role'     => 'asesor',
            ]);

            // Simpan data asesor
            $asesor = Asesor::create([
                'user_id'        => $user->id,
                'nama_asesor'    => $request->nama_asesor,
                'nip'            => $request->nip,
                'email'          => $request->email,
                'telepon'        => $request->telepon,
                'id_jurusan'     => $request->id_jurusan,
                'no_registrasi'  => $request->no_registrasi,
            ]);

            // Sync skema yang dipilih
            if ($request->has('skema_ids')) {
                $asesor->skemas()->sync($request->skema_ids);
            }

            // Kirim email berisi kredensial
            try {
                Mail::to($request->email)->send(new AsesorCredentialsMail($user, $plainPassword));
            } catch (\Exception $e) {
                // Log error tapi tidak menggagalkan proses
                \Log::error('Gagal mengirim email kredensial asesor: ' . $e->getMessage());
            }

            DB::commit();

            // Redirect dengan flash message password (hanya sekali)
            return redirect()->route('admin.asesor.index')
                ->with('success', 'Asesor berhasil ditambahkan dan akun login telah dibuat.')
                ->with('asesor_email', $request->email)
                ->with('asesor_password', $plainPassword);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error create asesor: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }
}
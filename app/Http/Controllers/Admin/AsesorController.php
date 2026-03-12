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

        $daftarSkema = SkemaSertifikasi::all(); // ganti nama variabel

        return view('admin.asesor.index', compact('asesor', 'daftarSkema'));
    }

    public function show($id)
    {
        $asesor = Asesor::with(['jurusan', 'skemas'])->findOrFail($id);
        return view('admin.asesor.show', compact('asesor'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_asesor' => 'required|string|max:255',
            'nip' => 'nullable|string|max:100|unique:asesor,nip',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:30',
            'id_jurusan' => 'nullable|exists:jurusan,id_jurusan',
            'no_registrasi' => 'nullable|string|max:100|unique:asesor,no_registrasi',
            'create_account' => 'nullable|in:1',
            'skema_ids' => 'nullable|array',
            'skema_ids.*' => 'exists:skema_sertifikasi,id_skema',
        ]);

        // tambahan validasi: jika create_account dicentang => email wajib & unik di users
        $validator->after(function ($v) use ($request) {
            if ($request->has('create_account')) {
                if (empty($request->email)) {
                    $v->errors()->add('email', 'Email wajib diisi jika membuat akun untuk asesor.');
                } elseif (User::where('email', $request->email)->exists()) {
                    $v->errors()->add('email', 'Email ini sudah terdaftar di sistem.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $data = $validator->validated();

            $plainPassword = null;
            $userId = null;

            if (isset($data['create_account']) && $data['create_account'] == '1') {
                // generate password random
                $plainPassword = Str::random(10);

                // create user
                $user = User::create([
                    'name' => $request->nama_asesor,
                    'email' => $request->email,
                    'password' => Hash::make($plainPassword),
                    'role' => 'asesor', // pastikan kolom role ada di tabel users
                ]);

                $userId = $user->id;

                // kirim email kredensial (jika konfigurasi mail sudah diisi)
                try {
                    Mail::to($request->email)->send(new AsesorCredentialsMail($user, $plainPassword));
                } catch (\Exception $e) {
                    \Log::error('Failed to send asesor credentials email: ' . $e->getMessage());
                }
            }

            // simpan data asesor dengan id_jurusan
            $asesor = Asesor::create([
                'user_id' => $userId,
                'nama_asesor' => $request->nama_asesor,
                'nip' => $request->nip,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'id_jurusan' => $request->id_jurusan,
                'no_registrasi' => $request->no_registrasi,
            ]);

            // sync skema yang dipilih
            if ($request->has('skema_ids')) {
                $asesor->skemas()->sync($request->skema_ids);
            }

            DB::commit();

            if ($plainPassword) {
                return redirect()->route('admin.asesor.index')
                    ->with('success', 'Asesor berhasil ditambahkan dan akun dibuat.')
                    ->with('asesor_email', $request->email)
                    ->with('asesor_password', $plainPassword);
            }

            return redirect()->route('admin.asesor.index')
                ->with('success', 'Asesor berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error create asesor: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                ->withInput();
        }
    }
}
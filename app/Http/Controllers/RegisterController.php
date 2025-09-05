<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asesi;
use App\Models\Asesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showAsesiForm()
    {
        return view('auth.register_asesi');
    }

    public function showAsesorForm()
    {
        return view('auth.register_asesor');
    }

    public function storeAsesi(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'nik' => 'required|digits_between:9,16',
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'telepon' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'asesi',
        ]);

        Asesi::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Asesi berhasil!');
    }


    public function storeAsesor(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'nama_asesor' => 'required',
            'nip' => 'nullable|digits:18',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'asesor',
        ]);

        Asesor::create([
            'user_id' => $user->id,
            'nama_asesor' => $request->nama_asesor,
            'nip' => $request->nip,
            'keahlian' => $request->keahlian,
            'jabatan' => $request->jabatan,
            'no_registrasi' => $request->no_registrasi,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran Asesor berhasil!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

  
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Ambil user yang sedang login
            $user = Auth::user();

            // Cek role dan redirect
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'asesor') {
                return redirect()->route('asesor.dashboard');
            } elseif ($user->role === 'asesi') {
                return redirect()->route('asesi.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors('Role tidak dikenali.');
            }
        }

        // Kalau gagal login
        return redirect()->route('login')->withErrors('Email atau password salah.');
    }

    public function showRegisterRole()
    {
        return view('auth.register-role');
    }
}

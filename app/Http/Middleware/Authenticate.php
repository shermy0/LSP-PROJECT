<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Models\User;

class Authenticate extends Middleware
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'asesor') {
                return redirect()->route('formperencanaan.index');
            } else {
                return redirect()->route('dashboard.asesi');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function showRegisterRole()
    {
        return view('auth.register-role');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,asesor,asesi',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login');
    }

    public function logout()
    {
         Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

    return redirect('/login');
}

}

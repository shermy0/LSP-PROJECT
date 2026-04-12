<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Asesi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    /* ===============================
       LOGIN
    =============================== */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors(['login' => 'Email atau password salah'])->onlyInput('email');
    }

    /**
     * Redirect user ke dashboard sesuai role
     */
    protected function redirectToDashboard()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        Log::info('Redirecting user role: ' . $user->role . ', ID: ' . $user->id);

        switch ($user->role) {
            case 'admin':
                if (Route::has('admin.dashboard')) {
                    return redirect()->route('admin.dashboard');
                }
                return redirect('/admin/dashboard');
            case 'asesor':
                if (Route::has('asesor.dashboard')) {
                    return redirect()->route('asesor.dashboard');
                }
                return redirect('/asesor/dashboard');
            case 'asesi':
                if (Route::has('asesi.dashboard')) {
                    return redirect()->route('asesi.dashboard');
                }
                return redirect('/asesi/dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors(['login' => 'Role tidak dikenali']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }

    /* ===============================
       REGISTER (ASESI)
    =============================== */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }

        try {
            // Jika kolom 'status' tidak ada, gunakan Jurusan::all()
            $jurusan = Jurusan::where('status', 'aktif')->get();
        } catch (\Exception $e) {
            $jurusan = Jurusan::all();
        }
        return view('auth.register', compact('jurusan'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'asesi',
            ]);

            Asesi::create([
                'user_id'      => $user->id,
                'jurusan_id'   => $request->jurusan_id,
                'nama_lengkap' => $request->name,
                'email'        => $request->email,
                // kolom lain bisa diisi default atau nullable
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registrasi gagal: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registrasi gagal: ' . $e->getMessage()])->withInput();
        }
    }
}
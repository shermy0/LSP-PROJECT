<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // sementara belum isi logika login
    }

    public function showRegisterRole()
    {
        return view('auth.register-role');
    }
}

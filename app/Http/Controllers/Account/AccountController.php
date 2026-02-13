<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        // Pastikan user sudah login
        $user = Auth::user();

        return view('account', compact('user'));
    }
}
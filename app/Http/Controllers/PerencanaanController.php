<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerencanaanController extends Controller
{
    public function index()
    {
        // kalo cuma mau nampilin view
        return view('formperencanaan'); 
    }

     
}
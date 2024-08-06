<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function index()
    {
        return view('secretary.dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kamera;

class HomeController extends Controller
{
    public function index()
    {
        $kameras = Kamera::latest()->get();
        return view('home', compact('kameras'));
    }
}

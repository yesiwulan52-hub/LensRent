<?php

namespace App\Http\Controllers;

use App\Models\Kamera;
use App\Models\Sewa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKamera = Kamera::sum('jumlah');
        $totalDisewa = Sewa::sum('jumlah_unit');
        $totalTersedia = $totalKamera - $totalDisewa;
        $pendapatan = Sewa::sum('total_harga');
        $stokMenipis = Kamera::where('jumlah', '<', 3)->count();

        return view('home', compact('totalKamera', 'totalTersedia', 'totalDisewa', 'pendapatan', 'stokMenipis'));
    }
}

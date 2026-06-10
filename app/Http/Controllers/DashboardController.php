<?php

namespace App\Http\Controllers;

use App\Models\StatusPengawasan;
use App\Models\KepatuhanBulanan;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $patuh = KepatuhanBulanan::query()->where('status_kepatuhan', 'PATUH')->count();
        $tidakPatuh = KepatuhanBulanan::query()->where('status_kepatuhan', 'TIDAK PATUH')->count();

        $selesai = StatusPengawasan::query()->where('status', 'SELESAI')->count();
        $belum = StatusPengawasan::query()->where('status', 'BELUM')->count();

        return view('dashboard', compact('patuh', 'tidakPatuh', 'selesai', 'belum'));
    }
}

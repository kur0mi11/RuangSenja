<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\KebutuhanPanti;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $donasiTerbaru = Donasi::query()
            ->where('donatur_id', auth()->id())
            ->latest()
            ->limit(5)
            ->get();
        $jumlahMenunggu = Donasi::query()
            ->where('donatur_id', auth()->id())
            ->where('status', 'menunggu')
            ->count();
        $jumlahKebutuhanAktif = KebutuhanPanti::query()
            ->where('status_kebutuhan', 'aktif')
            ->count();

        return view('donatur.dashboard', compact(
            'donasiTerbaru',
            'jumlahMenunggu',
            'jumlahKebutuhanAktif'
        ));
    }
}

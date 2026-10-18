<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\KebutuhanPanti;
use App\Models\Lansia;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        //hitung jumlah pengajuan yang belum diproses
        $pengajuanMenunggu = Donasi::where('status', 'menunggu')->count();

        //hitung jumlah penghuni yang masih aktif
        $penghuniAktif = Lansia::where('status_penghuni', 'aktif')->count();

        //hitung jumlah kebutuhan panti yang aktif
        $kebutuhanAktif = KebutuhanPanti::where('status_kebutuhan', 'aktif')->count();

        //hitung jumlah pengajuan yang sudah diterima
        $donasiDiterima = Donasi::where('status', 'diterima')->count();

        //ambil 5 pengajuan donasi terbaru beserta donaturnya
        $donasiTerbaru = Donasi::with('donatur:id,nama')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'pengajuanMenunggu',
            'penghuniAktif',
            'kebutuhanAktif',
            'donasiDiterima',
            'donasiTerbaru'
        ));
    }
}
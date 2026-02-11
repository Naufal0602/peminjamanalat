<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Alat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Statistik
        $totalPengguna = User::count();
        $totalAlat = Alat::count();

        // Peminjaman hari ini
        $peminjamanHariIni = Peminjaman::with('peminjam')
            ->whereDate('tanggal_pinjam', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // Pengembalian hari ini
        $pengembalianHariIni = Peminjaman::with(['peminjam', 'pengembalian'])
            ->whereHas('pengembalian', function ($q) use ($today) {
                $q->whereDate('tanggal_kembali', $today);
            })
            ->get();

        return view('petugas.dashboard', compact(
            'totalPengguna',
            'totalAlat',
            'peminjamanHariIni',
            'pengembalianHariIni'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Kategori;
use App\Models\LogAktivitas;

class DashboardAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
    {
        // Ambil data statistik dari database
        $totalPengguna = User::count();
        $totalAlat = Alat::count();
        $totalPeminjamanAktif = Peminjaman::where('status', 'aktif')->count();
        $totalKategori = Kategori::count();
        
        // Data peminjaman yang akan berakhir hari ini
        $peminjamanBerakhirHariIni = Peminjaman::whereDate('tanggal_kembali_rencana', now()->toDateString())
            ->where('status', 'aktif')
            ->count();
            
        // Data pertumbuhan bulanan (contoh sederhana)
        $pertumbuhanPengguna = $this->hitungPertumbuhanBulanan(User::class);
        $pertumbuhanAlat = $this->hitungPertumbuhanBulanan(Alat::class);
        
        // Peminjaman terbaru
       $peminjamanTerbaru = Peminjaman::with([
            'peminjam',
            'petugas',
            'detailPeminjaman.alat'
        ])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

            
        // Aktivitas terbaru dari log
        $aktivitasTerbaru = LogAktivitas::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Kategori baru bulan ini
        $kategoriBaruBulanIni = Kategori::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalAlat',
            'totalPeminjamanAktif',
            'totalKategori',
            'peminjamanBerakhirHariIni',
            'pertumbuhanPengguna',
            'pertumbuhanAlat',
            'peminjamanTerbaru',
            'aktivitasTerbaru',
            'kategoriBaruBulanIni'
        ));
    }

    /**
     * Hitung pertumbuhan bulanan
     */
    private function hitungPertumbuhanBulanan($model)
    {
        $bulanIni = $model::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $bulanLalu = $model::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
            
        if ($bulanLalu == 0) {
            return $bulanIni > 0 ? 100 : 0;
        }
        
        return round((($bulanIni - $bulanLalu) / $bulanLalu) * 100);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

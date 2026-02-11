<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Detail_Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardPeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Hitung statistik peminjaman
            $peminjamanAktif = Peminjaman::where('id_peminjam', $user->id)
            ->where('status', 'dipinjam')
            ->count();

        $totalPeminjaman = Peminjaman::where('id_peminjam', $user->id)->count();

        $peminjamanSelesai = Peminjaman::where('id_peminjam', $user->id)
            ->where('status', 'dikembalikan')
            ->count();

        $peminjamanPending = Peminjaman::where('id_peminjam', $user->id)
            ->where('status', 'pending')
            ->count();

        $peminjamanDitolak = Peminjaman::where('id_peminjam', $user->id)
            ->where('status', 'ditolak')
            ->count();

        $peminjamanAkanBerakhir = Peminjaman::where('id_peminjam', $user->id)
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali_rencana', '<=', Carbon::now()->addDays(7))
            ->whereDate('tanggal_kembali_rencana', '>=', Carbon::now())
            ->count();

            
        // Alat tersedia (status tersedia)
        $alatTersedia = Alat::where('status', 'tersedia')->count();
        $totalKategori = Kategori::count();
        
        // Daftar peminjaman aktif
        $peminjamanAktifList = Peminjaman::with(['detailPeminjaman.alat' => function($query) {
                $query->select('id_alat', 'nama_alat');
            }])
            ->where('id_peminjam', $user->id)
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_kembali_rencana', 'asc')
            ->take(3)
            ->get();
            
        // Riwayat terbaru
        $riwayatTerbaru = Peminjaman::with(['detailPeminjaman.alat' => function($query) {
                $query->select('id_alat', 'nama_alat');
            }])
            ->where('id_peminjam', $user->id)
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Alat populer berdasarkan jumlah peminjaman
        $alatPopuler = Alat::select('alat.id_alat', 'alat.nama_alat')
            ->join('detail_peminjaman', 'alat.id_alat', '=', 'detail_peminjaman.id_alat')
            ->join('peminjaman', 'detail_peminjaman.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->where('peminjaman.status', 'dikembalikan')
            ->selectRaw('COUNT(*) as total_peminjaman')
            ->groupBy('alat.id_alat', 'alat.nama_alat')
            ->orderBy('total_peminjaman', 'desc')
            ->take(5)
            ->get();


        return view('peminjam.dashboard', compact(
            'peminjamanAktif',
            'totalPeminjaman',
            'peminjamanSelesai',
            'peminjamanPending',
            'peminjamanDitolak',
            'peminjamanAkanBerakhir',
            'alatTersedia',
            'totalKategori',
            'peminjamanAktifList',
            'riwayatTerbaru',
            'alatPopuler'
        ));
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
<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'peminjam',
            'pengembalian',
            'detailPeminjaman.alat'
        ]);

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER TANGGAL
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $laporan = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $totalDenda = $laporan->sum(
            fn ($p) => optional($p->pengembalian)->total_denda ?? 0
        );

        return view('petugas.laporan.index', compact('laporan', 'totalDenda'));
    }


    public function printPdf(Request $request)
    {
        $query = Peminjaman::with(['peminjam', 'pengembalian']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $laporan = $query->orderBy('tanggal_pinjam')->get();

        $totalDenda = $laporan->sum(
            fn ($p) => optional($p->pengembalian)->total_denda ?? 0
        );

        $pdf = Pdf::loadView(
            'petugas.laporan.print',
            compact('laporan', 'totalDenda')
        )->setPaper('A4', 'portrait');

        return $pdf->download('laporan-peminjaman.pdf');
    }

}

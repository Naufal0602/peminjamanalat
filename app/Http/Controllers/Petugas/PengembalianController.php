<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Detail_Pengembalian;
use App\Models\Alat;
use App\Mail\PeringatanPengembalianMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Helpers\LogHelper;


class PengembalianController extends Controller
{
    // LIST PEMINJAMAN YANG BISA DIKEMBALIKAN
    public function index()
    {
        $peminjaman = Peminjaman::with('peminjam')
            ->where('status', 'dipinjam')
            ->get();

        return view('petugas.pengembalian.index', compact('peminjaman'));
    }

    // FORM PENGEMBALIAN
    public function create($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.alat', 'peminjam')
            ->findOrFail($id);

        return view('petugas.pengembalian.create', compact('peminjaman'));
    }

    // SIMPAN PENGEMBALIAN
    public function store(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $peminjaman = Peminjaman::with('detailPeminjaman')
                ->lockForUpdate()
                ->findOrFail($id);

            // HITUNG KETERLAMBATAN
            $tanggalHarusKembali = Carbon::parse($peminjaman->tanggal_kembali_rencana)->startOfDay();
            $hariSekarang = now()->startOfDay();

            $hariTelat = 0;

            if ($hariSekarang->gt($tanggalHarusKembali)) {
                $hariTelat = $tanggalHarusKembali->diffInDays($hariSekarang);
            }

            $dendaPerHari = 2000;
            $dendaTelat = $hariTelat * $dendaPerHari;

            // TOTAL DENDA KERUSAKAN
            $totalDendaKerusakan = 0;

            // SIMPAN DATA PENGEMBALIAN (AWAL, TOTAL SEMENTARA)
            $pengembalian = Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_kembali' => now(),
                'total_denda' => 0
            ]);

            // DETAIL PENGEMBALIAN + TAMBAH STOK
            foreach ($peminjaman->detailPeminjaman as $detail) {

                $dendaKerusakan = (int) ($request->denda[$detail->id_alat] ?? 0);
                $totalDendaKerusakan += $dendaKerusakan;

                Detail_Pengembalian::create([
                    'id_pengembalian' => $pengembalian->id_pengembalian,
                    'id_alat' => $detail->id_alat,
                    'jumlah' => $request->jumlah[$detail->id_alat],
                    'kondisi' => $request->kondisi[$detail->id_alat],
                    'denda' => $dendaKerusakan
                ]);

                Alat::where('id_alat', $detail->id_alat)
                    ->increment('stok', $request->jumlah[$detail->id_alat]);
            }

            // TOTAL AKHIR
            $totalDenda = $dendaTelat + $totalDendaKerusakan;

            // UPDATE TOTAL DENDA
            $pengembalian->update([
                'total_denda' => $totalDenda
            ]);

            // UPDATE STATUS PEMINJAMAN
            $peminjaman->update(['status' => 'selesai']);

            // LOG AKTIVITAS
            $aktivitas = "Memproses pengembalian untuk peminjaman ID: {$peminjaman->id_peminjaman}. "
                . "Denda keterlambatan: Rp {$dendaTelat}, "
                . "Denda kerusakan: Rp {$totalDendaKerusakan}, "
                . "Total denda: Rp {$totalDenda}.";
            LogHelper::simpan($aktivitas);
        });

        return redirect()->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diproses');
    }

    public function peringatan($id)
    {
        $peminjaman = Peminjaman::with('peminjam')->findOrFail($id);

        $hariTelat = max(
        0,
        Carbon::parse($peminjaman->tanggal_kembali_rencana)
            ->startOfDay()
            ->diffInDays(now()->startOfDay())
            );

        Mail::to($peminjaman->peminjam->email)
            ->send(new PeringatanPengembalianMail($peminjaman, $hariTelat));

        return back()->with('success', 'Email peringatan berhasil dikirim');
    }
}

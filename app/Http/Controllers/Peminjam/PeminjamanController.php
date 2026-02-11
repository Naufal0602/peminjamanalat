<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Detail_Peminjaman;
use App\Models\Kategori;
use App\Helpers\LogHelper;


class PeminjamanController extends Controller
{

    public function index()
{
    $peminjaman = Peminjaman::with('detailPeminjaman.alat')
        ->where('id_peminjam', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('peminjam.peminjaman.index', compact('peminjaman'));
}

    public function create()
    {
        $alat = Alat::where('stok', '>', 0)->get();
         $kategori = Kategori::all();
        return view('peminjam.peminjaman.create', compact('alat', 'kategori'));
    }

    public function store(Request $request)
    {
            $request->validate([
        'tanggal_kembali_rencana' => 'required|date',
        'alat' => 'required|array|min:1',
        'jumlah' => 'required|array',
        ]);

            $peminjaman = Peminjaman::create([
                'id_peminjam' => Auth::id(),
                'tanggal_pinjam' => now(),
                'tanggal_kembali_rencana' => $request->tanggal_kembali_rencana,
                'status' => 'menunggu'
            ]);

        foreach ($request->alat as $id_alat => $value) {
        Detail_Peminjaman::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'id_alat' => $id_alat,
            'jumlah' => $request->jumlah[$id_alat]
        ]);
    }
        LogHelper::simpan('Ajukan Peminjaman','Mengajukan peminjaman alat');
        return redirect()->route('peminjam.peminjaman.index')
                         ->with('success', 'Peminjaman berhasil diajukan');
    }

    public function batal($id)
{
    $peminjaman = Peminjaman::where('id_peminjaman', $id)
        ->where('id_peminjam', Auth::id())
        ->where('status', 'menunggu')
        ->firstOrFail();

    $peminjaman->update([
        'status' => 'dibatalkan'
    ]);

    LogHelper::simpan('Batalkan Peminjaman','Membatalkan peminjaman alat dengan ID: ' . $id);

    return redirect()->back()->with('success', 'Peminjaman berhasil dibatalkan.');
}

}

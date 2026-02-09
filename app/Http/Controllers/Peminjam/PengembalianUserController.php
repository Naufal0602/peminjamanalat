<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class PengembalianUserController extends Controller
{
    public function index()
    {
        $pengembalian = Peminjaman::with(['pengembalian'])
            ->where('id_peminjam', Auth::id())
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view(
            'peminjam.pengembalian.index',
            compact('pengembalian')
        );
    }
}

<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $peminjaman = Peminjaman::with([
            'peminjam',
            'detailPeminjaman.alat'
        ])
        ->whereIn('status', ['menunggu', 'disetujui'])
        ->orderBy('created_at', 'asc')
        ->get();

        return view('petugas.peminjaman.index', compact('peminjaman'));
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

    public function setujui($id)
{
    DB::transaction(function () use ($id) {

        $peminjaman = Peminjaman::with('detailPeminjaman')
            ->where('id_peminjaman', $id)
            ->lockForUpdate()
            ->firstOrFail();

        // update status peminjaman
        $peminjaman->update([
            'status' => 'disetujui',
            'id_petugas' => Auth::id()
        ]);

        // kurangi stok alat
        foreach ($peminjaman->detailPeminjaman as $detail) {
            $alat = Alat::findOrFail($detail->id_alat);

            if ($alat->stok < $detail->jumlah) {
                abort(400, 'Stok tidak mencukupi');
            }

            $alat->decrement('stok', $detail->jumlah);
        }
    });

    return back()->with('success', 'Peminjaman berhasil disetujui');
}


    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'ditolak',
            'id_petugas' => Auth::id()
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    public function serahkan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            abort(400, 'Status tidak valid');
        }

        $peminjaman->update([
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Status berubah menjadi sedang dipinjam');
    }
}

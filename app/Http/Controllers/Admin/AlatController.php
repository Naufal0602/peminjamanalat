<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
     public function index()
    {
        $alat = Alat::with('kategori')->get();
        return view('admin.alat.index', compact('alat'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.alat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_alat'   => 'required|string|max:255',
            'stok'        => 'required|integer',
            'kondisi'     => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('alat', 'public');
        }

        Alat::create([
            'id_kategori' => $request->id_kategori,
            'nama_alat'   => $request->nama_alat,
            'stok'        => $request->stok,
            'kondisi'     => $request->kondisi,
            'status'      => 'tersedia',
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('admin.alat.index')
                         ->with('success', 'Data alat berhasil ditambahkan');
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
        $alat = Alat::findOrFail($id);
        $kategori = Kategori::all();

        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $data = $request->validate([
            'id_kategori' => 'required',
            'nama_alat' => 'required',
            'stok' => 'required|integer',
            'kondisi' => 'required',
            'gambar' => 'nullable|image'
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat->update($data);

        return redirect()->route('admin.alat.index')
                        ->with('success', 'Alat berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $alat = Alat::findOrFail($id);

    // hapus gambar dari storage
    if ($alat->gambar && Storage::disk('public')->exists($alat->gambar)) {
        Storage::disk('public')->delete($alat->gambar);
    }

    $alat->delete();

    return redirect()->route('admin.alat.index')
                     ->with('success', 'Alat berhasil dihapus');
    }
}

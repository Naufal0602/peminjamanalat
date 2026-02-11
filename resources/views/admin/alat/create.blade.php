@extends('layouts.admin')

@section('title', 'Tambah Alat')
@section('header', 'Tambah Alat')

@section('content')
<div class="bg-white p-6 rounded justify-center shadow max-w-2xl">

    <form action="{{ route('admin.alat.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Kategori</label>
            <select name="id_kategori" class="w-full border p-2 rounded">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id_kategori }}">
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Nama Alat</label>
            <input type="text" name="nama_alat" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Stok</label>
            <input type="number" name="stok" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Kondisi</label>
            <select name="kondisi" class="w-full border p-2 rounded">
                <option value="">-- Pilih Kondisi --</option>
                <option value="baik">Baik</option>
                <option value="rusak_ringan">Rusak Ringan</option>
                <option value="rusak_berat">Rusak Berat</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Gambar</label>
            <input type="file" name="gambar" class="w-full">
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.alat.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </form>

</div>
@endsection


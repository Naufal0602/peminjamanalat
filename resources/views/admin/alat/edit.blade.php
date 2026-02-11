@extends('layouts.admin')

@section('title', 'Edit Alat')
@section('header', 'Edit Alat')

@section('content')
<div class="bg-white justify-center w-full p-6 rounded shadow max-w-2xl">

    <form action="{{ route('admin.alat.update', $alat->id_alat) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Kategori --}}
        <div class="mb-4">
            <label class="block mb-1">Kategori</label>
            <select name="id_kategori" class="w-full border p-2 rounded">
                @foreach ($kategori as $item)
                    <option value="{{ $item->id_kategori }}"
                        {{ $alat->id_kategori == $item->id_kategori ? 'selected' : '' }}>
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nama Alat --}}
        <div class="mb-4">
            <label class="block mb-1">Nama Alat</label>
            <input type="text"
                   name="nama_alat"
                   value="{{ $alat->nama_alat }}"
                   class="w-full border p-2 rounded">
        </div>

        {{-- Stok --}}
        <div class="mb-4">
            <label class="block mb-1">Stok</label>
            <input type="number"
                   name="stok"
                   value="{{ $alat->stok }}"
                   class="w-full border p-2 rounded">
        </div>

        {{-- Kondisi --}}
        <div class="mb-4">
            <label class="block mb-1">Kondisi</label>
            <select name="kondisi" class="w-full border p-2 rounded">
                <option value="baik" {{ $alat->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak_ringan" {{ $alat->kondisi == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="rusak_berat" {{ $alat->kondisi == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
        </div>

        {{-- Gambar --}}
        <div class="mb-4">
            <label class="block mb-1">Gambar</label>
            <input type="file" name="gambar" class="w-full">

            @if ($alat->gambar)
                <img src="{{ asset('storage/' . $alat->gambar) }}"
                     class="w-32 mt-2 rounded">
            @endif
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
            <a href="{{ route('admin.alat.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </form>

</div>
@endsection

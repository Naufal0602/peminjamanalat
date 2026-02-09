@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">

    <form action="{{ route('admin.kategori.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   class="w-full border p-2 rounded"
                   placeholder="Contoh: Alat Laboratorium"
                   value="{{ old('nama_kategori') }}"
                   required>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.kategori.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>
    </form>

</div>
@endsection

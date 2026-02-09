@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('header', 'Edit Kategori')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">

    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}"
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama Kategori</label>
            <input type="text"
                   name="nama_kategori"
                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
            <a href="{{ route('admin.kategori.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </form>

</div>
@endsection

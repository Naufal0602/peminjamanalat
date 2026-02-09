@extends('layouts.admin')

@section('title', 'Tambah Petugas')
@section('header', 'Tambah Petugas')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-md">

    <form action="{{ route('admin.pengguna.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Nama</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        {{-- role DIKUNCI --}}
        <input type="hidden" name="role" value="petugas">

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.pengguna.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </form>
</div>
@endsection

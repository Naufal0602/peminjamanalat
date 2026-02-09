@extends('layouts.peminjam')

@section('title', 'Dashboard peminjam')
@section('header', 'Dashboard peminjam')

@section('content')
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white mb-6">
        <h1 class="text-2xl font-bold">Selamat Datang, A</h1>
        <p>Anda login sebagai admin sistem.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500">Total Pengguna</p>
            <p class="text-2xl font-bold">124</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500">Total Alat</p>
            <p class="text-2xl font-bold">89</p>
        </div>
    </div>
@endsection

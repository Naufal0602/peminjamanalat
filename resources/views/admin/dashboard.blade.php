@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
<div class="p-6">
    <!-- Header Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white mb-8 shadow-lg">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, Admin</h1>
        <p class="text-blue-100 opacity-90">Anda login sebagai admin sistem.</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengguna Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPengguna }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75V21m-4.5-4.5H21"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if($pertumbuhanPengguna > 0)
                <span class="text-green-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    +{{ $pertumbuhanPengguna }}% dari bulan lalu
                </span>
                @elseif($pertumbuhanPengguna < 0)
                <span class="text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                    {{ $pertumbuhanPengguna }}% dari bulan lalu
                </span>
                @else
                <span class="text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10h14"></path>
                    </svg>
                    Tidak ada perubahan
                </span>
                @endif
            </div>
        </div>

        <!-- Total Alat Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Alat</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalAlat }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                @if($pertumbuhanAlat > 0)
                <span class="text-green-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    +{{ $pertumbuhanAlat }}% dari bulan lalu
                </span>
                @elseif($pertumbuhanAlat < 0)
                <span class="text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                    {{ $pertumbuhanAlat }}% dari bulan lalu
                </span>
                @else
                <span class="text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10h14"></path>
                    </svg>
                    Tidak ada perubahan
                </span>
                @endif
            </div>
        </div>

        <!-- Peminjaman Aktif Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Peminjaman Aktif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPeminjamanAktif }}</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                @if($peminjamanBerakhirHariIni > 0)
                    {{ $peminjamanBerakhirHariIni }} akan berakhir hari ini
                @else
                    Tidak ada yang berakhir hari ini
                @endif
            </div>
        </div>

        <!-- Kategori Alat Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Kategori Alat</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalKategori }}</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                @if($kategoriBaruBulanIni > 0)
                    {{ $kategoriBaruBulanIni }} kategori baru bulan ini
                @else
                    Tidak ada kategori baru bulan ini
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.pengguna.create') }}" class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="text-blue-700 font-medium">Tambah Pengguna</span>
            </a>

            <a href="{{ route('admin.alat.create') }}" class="bg-green-50 hover:bg-green-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <span class="text-green-700 font-medium">Tambah Alat</span>
            </a>

            <a href="{{ route('admin.peminjaman.index') }}" class="bg-purple-50 hover:bg-purple-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-purple-700 font-medium">Kelola Peminjaman</span>
            </a>

            <a href="{{ route('admin.log_aktivitas.index') }}" class="bg-yellow-50 hover:bg-yellow-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-yellow-700 font-medium">Log Aktivitas</span>
            </a>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Peminjaman Terbaru -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Peminjaman Terbaru</h2>
                <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
            </div>
            
            @if($peminjamanTerbaru->count() > 0)
            <div class="space-y-4">
                @foreach($peminjamanTerbaru as $peminjaman)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $peminjaman->peminjam->name ?? 'Tidak diketahui' }}</p>
                            <p class="text-sm text-gray-500">
                                @if($peminjaman->detailPeminjaman->count() > 0)
                                    {{ $peminjaman->detailPeminjaman->first()->alat->nama ?? 'Alat tidak ditemukan' }}
                                    @if($peminjaman->detailPeminjaman->count() > 1)
                                        + {{ $peminjaman->detailPeminjaman->count() - 1 }} alat lainnya
                                    @endif
                                @else
                                    Tidak ada alat
                                @endif
                            </p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                        @if($peminjaman->status == 'dipinjam') bg-green-100 text-green-800
                        @elseif($peminjaman->status == 'dikembalikan') bg-blue-100 text-blue-800
                        @elseif($peminjaman->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($peminjaman->status == 'ditolak') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($peminjaman->status) }}
                    </span>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">Belum ada data peminjaman</p>
            </div>
            @endif
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h2>
                <a href="{{ route('admin.log_aktivitas.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
            </div>
            
            @if($aktivitasTerbaru->count() > 0)
            <div class="space-y-4">
                @foreach($aktivitasTerbaru as $log)
                <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    @switch($log->aksi)
                        @case('create')
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 mt-1">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        @break
                        
                        @case('update')
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3 mt-1">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        @break
                        
                        @case('delete')
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 mt-1">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        @break
                        
                        @default
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 mt-1">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endswitch
                    
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $log->user->name ?? 'Sistem' }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $log->aktivitas }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($log->waktu)->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">Belum ada data aktivitas</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
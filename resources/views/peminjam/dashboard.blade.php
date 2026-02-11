@extends('layouts.peminjam')

@section('title', 'Dashboard Peminjam')
@section('header', 'Dashboard Peminjam')

@section('content')
<div class="p-6">
    <!-- Header Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white mb-8 shadow-lg">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name ?? 'Peminjam' }}</h1>
        <p class="text-blue-100 opacity-90">Anda login sebagai peminjam sistem.</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Peminjaman Aktif Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Peminjaman Aktif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $peminjamanAktif }}</p>
                </div>
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                @if($peminjamanAkanBerakhir > 0)
                    {{ $peminjamanAkanBerakhir }} akan berakhir minggu ini
                @else
                    Tidak ada yang berakhir minggu ini
                @endif
            </div>
        </div>

        <!-- Total Peminjaman Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPeminjaman }}</p>
                </div>
                <div class="bg-green-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                {{ $peminjamanSelesai }} peminjaman selesai
            </div>
        </div>

        <!-- Alat Tersedia Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Alat Tersedia</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $alatTersedia }}</p>
                </div>
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                {{ $totalKategori }} kategori tersedia
            </div>
        </div>

        <!-- Riwayat Card -->
        <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Ditolak/Tertunda</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $peminjamanDitolak + $peminjamanPending }}</p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                {{ $peminjamanPending }} pending, {{ $peminjamanDitolak }} ditolak
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Aksi Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('peminjam.peminjaman.create') }}" class="bg-blue-50 hover:bg-blue-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <span class="text-blue-700 font-medium">Pinjam Alat</span>
            </a>

            <a href="{{ route('peminjam.peminjaman.index') }}" class="bg-green-50 hover:bg-green-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </svg>
                </div>
                <span class="text-green-700 font-medium">Lihat Peminjaman</span>
            </a>

            <a href="{{ route('peminjam.pengembalian.index') }}" class="bg-purple-50 hover:bg-purple-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="text-purple-700 font-medium">Pengembalian</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="bg-yellow-50 hover:bg-yellow-100 rounded-lg p-4 text-center transition-colors duration-200">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="text-yellow-700 font-medium">Profil Saya</span>
            </a>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Peminjaman Aktif -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Peminjaman Aktif</h2>
                <a href="{{ route('peminjam.peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Semua</a>
            </div>
            
            @if($peminjamanAktifList->count() > 0)
            <div class="space-y-4">
                @foreach($peminjamanAktifList as $peminjaman)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-medium text-gray-800">
                                {{ $peminjaman->detailPeminjaman->first()->alat->nama ?? 'Alat tidak ditemukan' }}
                                @if($peminjaman->detailPeminjaman->count() > 1)
                                    <span class="text-sm text-gray-500">+ {{ $peminjaman->detailPeminjaman->count() - 1 }} alat lainnya</span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                No. Peminjaman: {{ $peminjaman->kode_peminjaman ?? 'N/A' }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Tanggal Pinjam</p>
                            <p class="font-medium">{{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Kembali</p>
                            <p class="font-medium">{{ $peminjaman->tanggal_kembali_rencana ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    
                    @php
                        $daysLeft = $peminjaman->tanggal_kembali_rencana ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->diffInDays(now(), false) : 0;
                    @endphp
                    
                    <div class="mt-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-500">Sisa Waktu</span>
                            <span class="font-medium @if($daysLeft < 3) text-red-600 @else text-gray-700 @endif">
                                @if($daysLeft > 0)
                                    {{ $daysLeft }} hari lagi
                                @elseif($daysLeft == 0)
                                    Hari ini
                                @else
                                    Terlambat {{ abs($daysLeft) }} hari
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                          @php
                                $totalDays = max(1, optional($peminjaman->tanggal_pinjam)
                                    ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)
                                        ->diffInDays($peminjaman->tanggal_kembali_rencana)
                                    : 1
                                );

                                $percentage = min(100, max(0, (($totalDays - max(0, $daysLeft)) / $totalDays) * 100));
                            @endphp
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">Tidak ada peminjaman aktif</p>
                <a href="{{ route('peminjam.peminjaman.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Pinjam Alat Sekarang
                </a>
            </div>
            @endif
        </div>

        <!-- Riwayat Terbaru -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Riwayat Terbaru</h2>
            </div>
            
            @if($riwayatTerbaru->count() > 0)
            <div class="space-y-4">
                @foreach($riwayatTerbaru as $peminjaman)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3
                            @if($peminjaman->status == 'dikembalikan') bg-green-100 text-green-600
                            @elseif($peminjaman->status == 'ditolak') bg-red-100 text-red-600
                            @elseif($peminjaman->status == 'pending') bg-yellow-100 text-yellow-600
                            @else bg-gray-100 text-gray-600 @endif">
                            @if($peminjaman->status == 'dikembalikan')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @elseif($peminjaman->status == 'ditolak')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            @elseif($peminjaman->status == 'pending')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $peminjaman->detailPeminjaman->first()->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $peminjaman->created_at ? \Carbon\Carbon::parse($peminjaman->created_at)->format('d M Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        @if($peminjaman->status == 'dikembalikan') bg-green-100 text-green-800
                        @elseif($peminjaman->status == 'ditolak') bg-red-100 text-red-800
                        @elseif($peminjaman->status == 'pending') bg-yellow-100 text-yellow-800
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
                <p class="text-gray-500">Belum ada riwayat peminjaman</p>
            </div>
            @endif
            
            <!-- Alat Populer -->
            <div class="mt-8 pt-6 border-t">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Alat Populer</h3>
                <div class="space-y-3">
                    @foreach($alatPopuler as $alat)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                            </div>
                            <span class="text-gray-700">{{ $alat->nama_alat }}</span>
                        </div>
                        <span class="text-sm text-gray-500">{{ $alat->total_peminjaman }}x dipinjam</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
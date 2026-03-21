@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('header', 'Dashboard Petugas')

@section('content')

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-6">
        <h1 class="text-2xl font-bold">Selamat Datang 👋</h1>
        <p>Ringkasan aktivitas peminjaman hari ini</p>
    </div>

    {{-- STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Pengguna</p>
            <p class="text-3xl font-bold">{{ $totalPengguna }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Total Alat</p>
            <p class="text-3xl font-bold">{{ $totalAlat }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Peminjaman Hari Ini</p>
            <p class="text-3xl font-bold">{{ $peminjamanHariIni->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <p class="text-gray-500 text-sm">Pengembalian Hari Ini</p>
            <p class="text-3xl font-bold">{{ $pengembalianHariIni->count() }}</p>
        </div>
    </div>

    {{-- PEMINJAMAN HARI INI --}}
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">📋 Peminjaman Hari Ini</h2>

        <table id="tablePeminjaman" class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama Peminjam</th>
                    <th class="p-2 border">Tanggal Pinjam</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamanHariIni as $item)
                    <tr>
                        <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border p-2">{{ $item->peminjam->name }}</td>
                        <td class="border p-2 text-center">{{ $item->tanggal_pinjam }}</td>
                        <td class="border p-2 text-center">
                            <span
                                class="px-2 py-1 text-xs rounded
                            {{ $item->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-500">
                            Tidak ada peminjaman hari ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PENGEMBALIAN HARI INI --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4">🔄 Pengembalian Hari Ini</h2>

        <table id="tablePengembalian" class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama Peminjam</th>
                    <th class="p-2 border">Tanggal Kembali</th>
                    <th class="p-2 border">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengembalianHariIni as $item)
                    <tr>
                        <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border p-2">{{ $item->peminjam->name }}</td>
                        <td class="border p-2 text-center">
                            {{ $item->pengembalian->tanggal_kembali }}
                        </td>
                        <td class="border p-2 text-right">
                            Rp {{ number_format($item->pengembalian->total_denda ?? 0) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-4 text-gray-500">
                            Tidak ada pengembalian hari ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">📊 Statistik Hari Ini</h2>
            <div style="width: 500px; height: 500px; margin: auto;">

                <canvas id="chartDashboard" height="100"></canvas>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tablePeminjaman').DataTable({
                    responsive: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        },
                        zeroRecords: "Data tidak ditemukan"
                    }
                });

                $('#tablePengembalian').DataTable({
                    responsive: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        },
                        zeroRecords: "Data tidak ditemukan"
                    }
                });
            });

            document.addEventListener("DOMContentLoaded", function() {

                const ctx = document.getElementById('chartDashboard').getContext('2d');

                const chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Peminjaman', 'Pengembalian', 'Total Denda'],
                        datasets: [{
                            data: [
                                {{ $peminjamanHariIni->count() }},
                                {{ $pengembalianHariIni->count() }},
                                {{ $totalDendaHariIni }}
                            ],
                            backgroundColor: [
                                '#3b82f6', // biru
                                '#10b981', // hijau
                                '#ef4444' // merah
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

            });
        </script>
    @endpush
@endsection

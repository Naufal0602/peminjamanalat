@extends('layouts.peminjam')

@section('title', 'Riwayat Peminjaman')
@section('header', 'Riwayat Peminjaman')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Peminjaman Saya</h1>
        <p class="text-gray-500 text-sm">Daftar peminjaman alat yang Anda ajukan</p>
    </div>

    <a href="{{ route('peminjam.peminjaman.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
        + Ajukan Peminjaman
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6 overflow-x-auto">

    @if ($peminjaman->isEmpty())
        <p class="text-center text-gray-500">Belum ada data peminjaman.</p>
    @else
    <table id="peminjamanTable" class="w-full border text-sm">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="border px-4 py-2 text-center">No</th>
                <th class="border px-4 py-2">Tanggal Pinjam</th>
                <th class="border px-4 py-2">Kembali Rencana</th>
                <th class="border px-4 py-2 text-center">Status</th>
                <th class="border px-4 py-2 text-center">Detail</th>
                <th class="border px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $item)
            <tr>
                <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                <td class="border px-4 py-2">{{ $item->tanggal_pinjam }}</td>
                <td class="border px-4 py-2">{{ $item->tanggal_kembali_rencana }}</td>

                {{-- STATUS --}}
                <td class="border px-4 py-2 text-center">
                    @if ($item->status === 'menunggu')
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Menunggu</span>
                    @elseif ($item->status === 'disetujui')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">disetujui</span>
                         @elseif ($item->status === 'dipinjam')
                        <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs">dipinjam</span>
                    @elseif ($item->status === 'ditolak')
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Ditolak</span>
                    @elseif ($item->status === 'dibatalkan')
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Dibatalkan</span>
                    @else
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">Selesai</span>
                    @endif
                </td>

                {{-- DETAIL --}}
                <td class="border px-4 py-2 text-center">
                    <details class="cursor-pointer">
                        <summary class="text-blue-600 text-xs">Lihat</summary>
                        <ul class="mt-2 text-left list-disc pl-4">
                            @foreach ($item->detailPeminjaman as $detail)
                                <li>{{ $detail->alat->nama_alat }} ({{ $detail->jumlah }})</li>
                            @endforeach
                        </ul>
                    </details>
                </td>

                {{-- AKSI --}}
                <td class="border px-4 py-2 text-center">
                    @if ($item->status === 'menunggu')
                        <form action="{{ route('peminjam.peminjaman.batal', $item->id_peminjaman) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan peminjaman ini?')">
                            @csrf
                            @method('PUT')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Batalkan
                            </button>
                        </form>
                    @else
                        <span class="text-gray-400 text-xs">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</div>

<script>
$(document).ready(function () {
    $('#peminjamanTable').DataTable({
        pageLength: 5,
        lengthChange: false,
        ordering: true,
        language: {
            search: "Cari:",
            paginate: {
                next: "›",
                previous: "‹"
            },
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data"
        }
    });
});
</script>


@endsection

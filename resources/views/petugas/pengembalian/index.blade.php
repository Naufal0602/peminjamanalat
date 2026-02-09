@extends('layouts.petugas')

@section('title', 'Pengembalian')
@section('header', 'Pengembalian Alat')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white mb-6">
        <h1 class="text-2xl font-bold">Daftar Pengembalian</h1>
        <p>Menunggu persetujuan petugas</p>
    </div>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table id="datatable" class="w-full border text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">Peminjam</th>
                    <th class="border p-2">Tanggal Pinjam</th>
                    <th class="border p-2">Tanggal Kembali Rencana</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2 text-center">{{ $loop->iteration }}</td>

                    <td class="border p-2">
                        {{ $item->peminjam->name }}
                    </td>

                    <td class="border p-2 text-center">
                        {{ $item->tanggal_pinjam }}
                    </td>

                    <td class="border p-2 text-center">
                        {{ $item->tanggal_kembali_rencana }}
                    </td>

                    <td class="border p-2 text-center">
                        @if (\Carbon\Carbon::now()->startOfDay()->gt(
                                \Carbon\Carbon::parse($item->tanggal_kembali_rencana)->startOfDay()
                            ))
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                                Terlambat
                            </span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Tepat Waktu
                            </span>
                        @endif
                    </td>

                    <td class="border p-2 text-center flex flex-wrap gap-2 justify-center">
                        {{-- PROSES PENGEMBALIAN --}}
                        <a href="{{ route('petugas.pengembalian.create', $item->id_peminjaman) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                            Proses
                        </a>

                        {{-- PERINGATAN --}}
                        @if (\Carbon\Carbon::now()->gt($item->tanggal_kembali_rencana))
                        <form action="{{ route('petugas.pengembalian.peringatan', $item->id_peminjaman) }}"
                              method="POST">
                            @csrf
                            <button
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                Peringatan
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection


@push('scripts')
<script>
$(document).ready(function () {
    $('#datatable').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                next: "Next",
                previous: "Prev"
            }
        }
    });
});
</script>
@endpush

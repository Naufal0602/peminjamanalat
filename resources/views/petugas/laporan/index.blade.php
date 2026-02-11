@extends('layouts.petugas')

@section('title', 'Laporan Peminjaman')
@section('header', 'Laporan Peminjaman')

@section('content')

<div class="bg-white rounded-xl shadow p-6 mb-6">

   <form method="GET" class="flex gap-4 mb-4">
        <input type="date" name="tanggal_awal" class="border p-2 rounded"
            value="{{ request('tanggal_awal') }}">

        <input type="date" name="tanggal_akhir" class="border p-2 rounded"
            value="{{ request('tanggal_akhir') }}">

        <select name="status" class="border p-2 rounded">
            <option value="">-- Semua Status --</option>
            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                Sedang Dipinjam
            </option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                Selesai
            </option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Filter
        </button>

        <a href="{{ route('petugas.laporan.printPdf', request()->query()) }}"
        class="bg-red-600 text-white px-4 py-2 rounded inline-block">
            Print PDF
        </a>
    </form>


    <table id="datatable" class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Total Denda</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->peminjam->name }}</td>
                <td class="text-center">{{ $item->tanggal_pinjam }}</td>
                <td class="text-center">
                    @if ($item->pengembalian)
                        {{ $item->pengembalian->tanggal_kembali }}
                    @else
                    {{ $item->tanggal_kembali_rencana }}
                    @endif
                </td>
                <td class="text-center">
                    @if ($item->status === 'dipinjam')
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                            Sedang Dipinjam
                        </span>
                    @else
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                            Selesai
                        </span>
                    @endif
                </td>
                <td class="text-right">
                    Rp {{ number_format(optional($item->pengembalian)->total_denda ?? 0) }}
                </td>
                <td class="text-center">
              <button
                onclick="openModal('modal-{{ $item->id_peminjaman }}')"
                class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">
                    Lihat
                </button>
                </td>
                </tr>

            </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($laporan as $item)
<div id="modal-{{ $item->id_peminjaman }}"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow p-6 w-2/3 max-w-2xl">
        <h3 class="text-lg font-bold mb-4">
            Detail Peminjaman – {{ $item->peminjam->name }}
        </h3>

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Nama Alat</th>
                    <th class="border p-2">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->detailPeminjaman as $detail)
                <tr>
                    <td class="border p-2">{{ $detail->alat->nama_alat }}</td>
                    <td class="border p-2 text-center">{{ $detail->jumlah }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <button
                onclick="document.getElementById('modal-{{ $item->id_peminjaman }}').classList.add('hidden')"
                class="bg-gray-500 text-white px-4 py-2 rounded">
                Tutup
            </button>
        </div>
    </div>
</div>
@endforeach

    

    <div class="mt-4 text-right font-bold">
        Total Denda Keseluruhan:
        Rp {{ number_format($totalDenda) }}
    </div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#datatable').DataTable({
        pageLength: 10,
        order: [[2, 'desc']],
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

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>
@endpush

@extends('layouts.peminjam')

@section('title', 'Riwayat Pengembalian')
@section('header', 'Riwayat Pengembalian')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    @if ($pengembalian->isEmpty())
        <p class="text-center text-gray-500">
            Belum ada data pengembalian.
        </p>
    @else

    <table id="datatable" class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th>No</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengembalian as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>

                <td class="text-center">
                    {{ $item->tanggal_pinjam }}
                </td>

                <td class="text-center">
                    {{ optional($item->pengembalian)->tanggal_kembali ?? '-' }}
                </td>

                <td class="text-center">
                    @if ($item->status === 'selesai')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                            Selesai
                        </span>
                    @elseif ($item->status === 'disetujui')
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                            Dipinjam
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                            Menunggu
                        </span>
                    @endif
                </td>

                <td class="text-right">
                    Rp {{ number_format(optional($item->pengembalian)->total_denda ?? 0) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @endif
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#datatable').DataTable({
        pageLength: 10,
        searching: true,
        ordering: false,
        language: {
            search: "Cari:",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
        }
    });
});
</script>
@endpush

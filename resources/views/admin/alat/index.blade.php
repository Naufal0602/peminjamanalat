@extends('layouts.admin')

@section('title', 'Data Alat')
@section('header', 'Data Alat')

@section('content')

<div class="bg-white rounded-lg shadow p-6">

    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.alat.create') }}"
           class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-2 rounded-md transition">
            + Tambah Alat
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="datatable" class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-3 py-2 text-left">No</th>
                    <th class="border px-3 py-2 text-left">Nama Alat</th>
                    <th class="border px-3 py-2 text-left">Kategori</th>
                    <th class="border px-3 py-2 text-left">Stok</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-left">Gambar</th>
                    <th class="border px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($alat as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-3 py-2">{{ $item->nama_alat }}</td>
                    <td class="border px-3 py-2">{{ $item->kategori->nama_kategori }}</td>
                    <td class="border px-3 py-2">{{ $item->stok }}</td>
                    <td class="border px-3 py-2">
                        @if ($item->status == 'tersedia')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Tersedia
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Dipinjam
                            </span>
                        @endif
                    </td>
                    <td class="border px-3 py-2">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                 class="w-16 h-16 object-cover rounded">
                        @endif
                    </td>
                    <td class="px-3 py-2 flex gap-2">
                        <a href="{{ route('admin.alat.edit', $item->id_alat) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                            Edit
                        </a>

                        <form action="{{ route('admin.alat.destroy', $item->id_alat) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

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

@endsection

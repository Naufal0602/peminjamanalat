@extends('layouts.admin')

@section('title', 'Data Kategori')
@section('header', 'Data Kategori')

@section('content')

<div class="bg-white rounded-lg shadow p-6">

    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.kategori.create') }}"
           class="bg-lime-500 hover:bg-lime-600 text-white px-4 py-2 rounded-md transition">
            + Tambah Kategori
        </a>
    </div>

    <div class="overflow-x-auto">
        <table id="datatable" class="w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-3 py-2 text-left w-16">No</th>
                    <th class="border px-3 py-2 text-left">Nama Kategori</th>
                    <th class="border px-3 py-2 text-left w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2 text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="border px-3 py-2">
                        {{ $item->nama_kategori }}
                    </td>
                    <td class="border px-3 py-2 flex gap-2">
                        <a href="{{ route('admin.kategori.edit', $item->id_kategori) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                            Edit
                        </a>

                        <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}"
                              method="POST"
                              onsubmit="return confirm('Hapus kategori ini?')">
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

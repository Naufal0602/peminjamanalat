@extends('layouts.admin')

@section('title', 'Daftar Pengguna')
@section('header', 'Daftar Pengguna (Petugas)')

@section('content')
<div class="bg-white rounded shadow p-6">

    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.pengguna.create') }}"
           class="bg-lime-500 text-white px-4 py-2 rounded">
            + Tambah Petugas
        </a>
    </div>

    <table id="userTable" class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">No</th>
                <th class="border px-3 py-2">Nama</th>
                <th class="border px-3 py-2">Email</th>
                <th class="border px-3 py-2">Role</th>
                <th class="border px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $item)
            <tr>
                <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                <td class="border px-3 py-2">{{ $item->name }}</td>
                <td class="border px-3 py-2">{{ $item->email }}</td>
                <td class="border px-3 py-2 text-center">
                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                        {{ $item->role }}
                    </span>
                </td>
                <td class="border px-3 py-2 text-center">
                    <form action="{{ route('admin.pengguna.destroy', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus petugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    $('#userTable').DataTable({
        language: {
            search: "",
            searchPlaceholder: "Cari pengguna...",
            lengthMenu: "_MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                next: '→',
                previous: '←'
            }
        },
        pageLength: 10,
        order: [[0, 'asc']], // JANGAN kolom aksi
        columnDefs: [
            { targets: 0, className: 'text-center' }
        ]
    });
});
</script>
@endpush


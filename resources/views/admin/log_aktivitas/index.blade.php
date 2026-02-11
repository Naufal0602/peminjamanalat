@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
    /* Customizing DataTables to look like Tailwind */
    .dataTables_wrapper .dataTables_length select {
        @apply rounded-lg border-gray-300 py-1 px-5;
    }
    .dataTables_wrapper .dataTables_filter input {
        @apply rounded-lg border-gray-300 py-1 px-3 ml-2 outline-none focus:ring-2 focus:ring-blue-500;
    }
    table.dataTable {
        @apply border-collapse border-spacing-0 w-full !important;
    }
    table.dataTable thead th {
        @apply bg-gray-50 text-gray-600 uppercase text-xs font-semibold tracking-wider border-b border-gray-200 px-6 py-4 text-left !important;
    }
    table.dataTable tbody td {
        @apply px-6 py-4 border-b border-gray-100 text-sm text-gray-700 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-600 text-white border-blue-600 rounded-lg !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        @apply bg-blue-50 text-blue-600 border-transparent rounded-lg !important;
    }
</style>
@endsection

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📋 Log Aktivitas</h1>
            <p class="text-sm text-gray-500 italic">Riwayat aktivitas seluruh pengguna sistem.</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Role</label>
                <select name="role" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Role</option>
                    <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 text-sm">
                    Filter
                </button>
                <a href="{{ route('admin.log_aktivitas.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-center font-semibold py-2 px-4 rounded-lg transition duration-200 text-sm">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4">
            <table id="logTable" class="w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr class="hover:bg-gray-50 transition duration-150 text-center justify-center">
                        <td class="text-center font-medium text-gray-400">{{ $loop->iteration }}</td>
                        <td>
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">
                                    {{ strtoupper(substr($log->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <span class="font-semibold text-gray-800">{{ $log->user->name ?? 'Guest' }}</span>
                            </div>
                        </td>
                       <td>
                            @php
                                // Mengambil role langsung dari relasi user
                                $userRole = strtolower($log->user->role ?? ''); 
                                
                                $roleColors = [
                                    'admin'    => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'petugas'  => 'bg-green-100 text-green-700 border-green-200',
                                    'peminjam' => 'bg-blue-100 text-blue-700 border-blue-200',
                                ];
                                
                                $colorClass = $roleColors[$userRole] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp

                            @if($userRole)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                                    {{ strtoupper($userRole) }}
                                </span>
                            @else
                                <span class="text-gray-400 italic text-xs">Tidak ada role</span>
                            @endif
                        </td>
                        <td class="max-w-xs truncate" title="{{ $log->aktivitas }}">
                            {{ $log->aktivitas }}
                        </td>
                        <td class="text-gray-500" data-sort="{{ $log->waktu }}">
                            {{ \Carbon\Carbon::parse($log->waktu)->translatedFormat('d M Y') }}
                            <span class="block text-[10px] text-gray-400 uppercase font-bold tracking-tighter">
                                {{ \Carbon\Carbon::parse($log->waktu)->format('H:i') }} WIB
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#logTable').DataTable({
            language: {
                search: "",
                searchPlaceholder: "Cari log...",
                lengthMenu: "_MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    next: '<span class="px-2">→</span>',
                    previous: '<span class="px-2">←</span>'
                }
            },
            pageLength: 10,
            order: [[4, 'desc']],
            columnDefs: [
                { targets: 0, className: 'text-center' }
            ]
        });
    });
</script>
@endpush
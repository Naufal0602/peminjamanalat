@extends('layouts.admin')

@section('header','Data Peminjaman')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px;
    }
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }
    .badge-success { background-color: #d1fae5; color: #065f46; }
    .badge-warning { background-color: #fef3c7; color: #92400e; }
    .badge-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-info { background-color: #dbeafe; color: #1e40af; }
    .badge-secondary { background-color: #f3f4f6; color: #374151; }
</style>
@endpush

@section('content')
<div class="bg-white p-6 rounded-xl shadow-lg">

    <!-- Header dengan Filter dan Tombol -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Peminjaman</h1>
            <p class="text-gray-600">Kelola semua data peminjaman alat</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <!-- Filter Status -->
            <select id="filter-status" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="disetujui">Disetujui</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
            
            <!-- Filter Tanggal -->
            <input type="date" id="filter-tanggal-awal" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Dari">
            <input type="date" id="filter-tanggal-akhir" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" placeholder="Sampai">
            
            <!-- Tombol Tambah -->
            <a href="{{ route('admin.peminjaman.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Peminjaman
            </a>
        </div>
    </div>

    <!-- Card Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Peminjaman</p>
                    <p class="text-2xl font-bold">{{ $totalPeminjaman }}</p>
                </div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Disetujui</p>
                    <p class="text-2xl font-bold">{{ $statusCounts['disetujui'] ?? 0 }}</p>
                </div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Dipinjam</p>
                    <p class="text-2xl font-bold">{{ $statusCounts['dipinjam'] ?? 0 }}</p>
                </div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-xl shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Ditolak</p>
                    <p class="text-2xl font-bold">{{ $statusCounts['ditolak'] ?? 0 }}</p>
                </div>
                <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Tabel dengan DataTables -->
    <div class="overflow-x-auto">
        <table id="peminjamanTable" class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-50">
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Petugas</th>
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alat Dipinjam</th>
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="p-3 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($peminjaman as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 border-b">{{ $loop->iteration }}</td>
                    
                    <td class="p-3 border-b">
                        <div>
                            <p class="font-medium text-gray-900">{{ $p->peminjam->name ?? '-' }}</p>
                            <p class="text-sm text-gray-500">{{ $p->peminjam->email ?? '-' }}</p>
                        </div>
                    </td>

                    <td class="p-3 border-b">
                        {{ $p->petugas?->name ?? '-' }}
                    </td>

                    <td class="p-3 border-b">
                        <div class="max-w-xs">
                            @foreach($p->detailPeminjaman as $d)
                                <div class="flex justify-between items-center mb-1 last:mb-0">
                                    <span class="text-sm">{{ $d->alat->nama_alat ?? 'Alat tidak ditemukan' }}</span>
                                    <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                        {{ $d->jumlah }} pcs
                                    </span>
                                </div>
                            @endforeach
                            @if($p->detailPeminjaman->count() > 2)
                            <button type="button" 
                                    onclick="showDetailAlat({{ $p->id_peminjaman }})"
                                    class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                                + {{ $p->detailPeminjaman->count() - 2 }} alat lainnya
                            </button>
                            @endif
                        </div>
                    </td>

                    <td class="p-3 border-b">
                        <div>
                            <p class="text-sm">
                                <span class="font-medium">Pinjam:</span> 
                                {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}
                            </p>
                            <p class="text-sm">
                                <span class="font-medium">Kembali:</span> 
                                {{ \Carbon\Carbon::parse($p->tanggal_kembali_rencana)->format('d/m/Y') }}
                            </p>
                        </div>
                    </td>

                    <td class="p-3 border-b">
                        @php
                            $statusColors = [
                                'disetujui' => 'success',
                                'dipinjam' => 'warning',
                                'dikembalikan' => 'info',
                                'ditolak' => 'danger',
                                'pending' => 'secondary'
                            ];
                            $color = $statusColors[$p->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $color }} capitalize">
                            {{ $p->status }}
                        </span>
                    </td>

                    <td class="p-3 border-b">
                        <div class="flex flex-col gap-2">
                            <!-- Tombol Detail/Edit -->
                            <a href="{{ route('admin.peminjaman.edit', $p->id_peminjaman) }}"
                               class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.peminjaman.destroy', $p->id_peminjaman) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Alat -->
<div id="modal-detail" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full max-h-[80vh] overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Detail Alat Dipinjam</h3>
            <button type="button" 
                    onclick="closeModal()"
                    class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-4 overflow-y-auto" id="modal-content">
            <!-- Konten akan diisi oleh JavaScript -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#peminjamanTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
           {
    extend: 'excel',
    text: '<i class="fas fa-file-excel mr-2"></i>Excel',
    className:
        'inline-flex items-center px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium ' +
        'hover:bg-green-700 focus:ring-2 focus:ring-green-400 focus:outline-none',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5]
    }
},
{
    extend: 'pdf',
    text: '<i class="fas fa-file-pdf mr-2"></i>PDF',
    className:
        'inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium ' +
        'hover:bg-red-700 focus:ring-2 focus:ring-red-400 focus:outline-none',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5]
    },
    title: 'Laporan Data Peminjaman',
    customize: function (doc) {
        doc.styles.tableHeader.alignment = 'center';
        doc.styles.tableHeader.fontSize = 10;
        doc.defaultStyle.fontSize = 9;

        // Lebar kolom PDF (harus sama jumlah kolom)
        doc.content[1].table.widths = [
            '5%',  // No
            '20%', // Peminjam
            '15%', // Petugas
            '25%', // Alat
            '15%', // Tgl Pinjam
            '20%'  // Status
        ];
    }
},
{
    extend: 'print',
    text: '<i class="fas fa-print mr-2"></i>Print',
    className:
        'inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium ' +
        'hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:outline-none',
    exportOptions: {
        columns: [0, 1, 2, 3, 4, 5]
    }
}

        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(disaring dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Berikutnya",
                previous: "Sebelumnya"
            }
        },
        responsive: true,
        order: [[0, 'asc']],
        pageLength: 10
    });

    // Filter berdasarkan status
    $('#filter-status').on('change', function() {
        table.column(5).search(this.value).draw();
    });

    // Filter berdasarkan tanggal
    $('#filter-tanggal-awal, #filter-tanggal-akhir').on('change', function() {
        var start = $('#filter-tanggal-awal').val();
        var end = $('#filter-tanggal-akhir').val();
        
        if (start && end) {
            table.column(4).search(start + '|' + end).draw();
        } else if (start) {
            table.column(4).search(start).draw();
        } else if (end) {
            table.column(4).search('|' + end).draw();
        } else {
            table.column(4).search('').draw();
        }
    });
});

// Fungsi untuk menampilkan modal detail alat
function showDetailAlat(id) {
    // Ambil data dari row yang sesuai
    var row = $('#peminjamanTable').find(`tr:has(td:contains("${id}"))`);
    var alatHtml = '';
    
    // Buat daftar alat
    row.find('.alat-list div').each(function() {
        alatHtml += '<div class="flex justify-between items-center py-2 border-b last:border-0">' +
                    '<span>' + $(this).find('span').first().text() + '</span>' +
                    '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">' + 
                    $(this).find('span').last().text() + '</span>' +
                    '</div>';
    });
    
    // Isi modal content
    $('#modal-content').html(`
        <div class="space-y-4">
            <div>
                <h4 class="font-semibold text-gray-700 mb-2">Daftar Alat Dipinjam:</h4>
                <div class="space-y-2">
                    ${alatHtml}
                </div>
            </div>
        </div>
    `);
    
    // Tampilkan modal
    $('#modal-detail').removeClass('hidden').addClass('flex');
}

// Fungsi untuk menutup modal
function closeModal() {
    $('#modal-detail').removeClass('flex').addClass('hidden');
}

// Tutup modal ketika klik di luar konten
$('#modal-detail').click(function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
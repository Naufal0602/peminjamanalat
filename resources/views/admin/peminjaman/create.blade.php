@extends('layouts.admin')

@section('header','Tambah Peminjaman')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-6xl mx-auto">

<!-- FORM PENCARIAN DAN FILTER -->
<div class="mb-6 bg-gray-50 p-4 rounded-lg border">
    <h3 class="font-bold mb-3 text-gray-700 text-lg">Filter & Pencarian Alat</h3>
    
    <form method="GET" action="{{ route('admin.peminjaman.create') }}" class="space-y-4">
        <!-- Baris 1: Pencarian dan Filter Utama -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Alat</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Ketik nama alat..."
                       class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Filter Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" 
                        class="w-full border border-gray-300 p-2 rounded-lg">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori_list as $kategori)
                        <option value="{{ $kategori->id_kategori }}" 
                                {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Kondisi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                <select name="kondisi" 
                        class="w-full border border-gray-300 p-2 rounded-lg">
                    <option value="">Semua Kondisi</option>
                    @foreach($kondisi_list as $kondisi)
                        <option value="{{ $kondisi }}" 
                                {{ request('kondisi') == $kondisi ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $kondisi)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" 
                        class="w-full border border-gray-300 p-2 rounded-lg">
                    <option value="">Semua Status</option>
                    @foreach($status_list as $status)
                        <option value="{{ $status }}" 
                                {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Baris 2: Checkbox dan Tombol -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4">
                <!-- Filter Stok Tersedia -->
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" 
                           name="stok_tersedia" 
                           value="1"
                           {{ request('stok_tersedia') ? 'checked' : '' }}
                           class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="text-sm text-gray-700">Hanya alat dengan stok > 0</span>
                </label>
                
                <!-- Reset Filter -->
                <a href="{{ route('admin.peminjaman.create') }}" 
                   class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                    Tampilkan semua alat
                </a>
            </div>
            
            <div class="flex gap-2">
                <!-- Reset Button -->
                <a href="{{ route('admin.peminjaman.create') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
                
                <!-- Search Button -->
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Terapkan Filter
                </button>
            </div>
        </div>
        
        <!-- Info Filter Aktif -->
        @if(request()->hasAny(['search', 'kategori', 'kondisi', 'status', 'stok_tersedia']))
        <div class="mt-3 p-3 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-800 font-medium">Filter aktif:</p>
            <div class="flex flex-wrap gap-2 mt-1">
                @if(request('search'))
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                    Pencarian: "{{ request('search') }}"
                </span>
                @endif
                
                @if(request('kategori'))
                @php $selectedKategori = $kategori_list->firstWhere('id_kategori', request('kategori')); @endphp
                @if($selectedKategori)
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                    Kategori: {{ $selectedKategori->nama_kategori }}
                </span>
                @endif
                @endif
                
                @if(request('kondisi'))
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                    Kondisi: {{ ucfirst(str_replace('_', ' ', request('kondisi'))) }}
                </span>
                @endif
                
                @if(request('status'))
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                    Status: {{ ucfirst(request('status')) }}
                </span>
                @endif
                
                @if(request('stok_tersedia'))
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                    Stok tersedia
                </span>
                @endif
            </div>
        </div>
        @endif
    </form>
</div>

<!-- FORM PEMINJAMAN UTAMA -->
<form method="POST" action="{{ route('admin.peminjaman.store') }}" id="form-peminjaman">
@csrf

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Peminjam -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1 required">Peminjam</label>
        <select name="id_peminjam" class="w-full border border-gray-300 p-2 rounded-lg" required>
            <option value="">-- Pilih Peminjam --</option>
            @foreach($peminjam as $u)
                <option value="{{ $u->id }}" {{ old('id_peminjam') == $u->id ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>
    </div>
    
    <!-- Tanggal Pinjam -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1 required">Tanggal Pinjam</label>
        <input type="date" 
               name="tanggal_pinjam"
               value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
               min="{{ date('Y-m-d') }}"
               class="w-full border border-gray-300 p-2 rounded-lg" 
               required>
    </div>
    
    <!-- Tanggal Kembali Rencana -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1 required">Tanggal Kembali Rencana</label>
        <input type="date" 
               name="tanggal_kembali_rencana"
               value="{{ old('tanggal_kembali_rencana', date('Y-m-d', strtotime('+7 days'))) }}"
               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
               max="{{ date('Y-m-d', strtotime('+30 days')) }}"
               class="w-full border border-gray-300 p-2 rounded-lg" 
               required>
        <p class="text-xs text-gray-500 mt-1">Maksimal 30 hari dari tanggal pinjam</p>
    </div>
</div>

<hr class="my-6">

<!-- DAFTAR ALAT -->
<h3 class="font-bold mb-4 text-lg text-gray-800 flex items-center justify-between">
    <span>Alat Dipinjam</span>
    <span class="text-sm font-normal text-gray-500" id="alat-count">
        {{ $alat->count() }} alat ditemukan
    </span>
</h3>

@if($alat->isEmpty())
<div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <p class="mt-3 text-gray-500 font-medium">Tidak ada alat ditemukan</p>
    <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci pencarian atau filter yang berbeda</p>
</div>
@else
<div class="max-h-[500px] overflow-y-auto border border-gray-200 rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 sticky top-0">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">
                    Pilih
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama Alat & Informasi
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                    Stok
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">
                    Jumlah Pinjam
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($alat as $a)
            <tr class="hover:bg-gray-50 transition" data-stok="{{ $a->stok }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox"
                           name="alat[{{ $loop->index }}][id_alat]"
                           value="{{ $a->id_alat }}"
                           id="alat_{{ $a->id_alat }}"
                           class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 alat-checkbox"
                           data-index="{{ $loop->index }}">
                </td>
                <td class="px-6 py-4">
                    <label for="alat_{{ $a->id_alat }}" class="cursor-pointer">
                        <div class="flex items-start gap-3">
                            @if($a->gambar)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $a->gambar) }}" 
                                     alt="{{ $a->nama_alat }}"
                                     class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            </div>
                            @endif
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $a->nama_alat }}</h4>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if($a->kategori)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $a->kategori->nama_kategori }}
                                    </span>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                        {{ $a->kondisi == 'baik' ? 'bg-green-100 text-green-800' : 
                                           ($a->kondisi == 'rusak_ringan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $a->kondisi)) }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                                        {{ $a->status == 'tersedia' ? 'bg-green-100 text-green-800' : 
                                           ($a->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </div>
                                @if($a->stok == 0)
                                <p class="text-xs text-red-600 mt-1 font-medium">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.284 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    Stok habis
                                </p>
                                @endif
                            </div>
                        </div>
                    </label>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="text-lg font-bold {{ $a->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $a->stok }}
                        </span>
                        <div class="ml-3 w-24 bg-gray-200 rounded-full h-2">
                            @php
                                $percentage = min(100, ($a->stok / 100) * 100); // Anggap maksimal stok 100 untuk visualisasi
                            @endphp
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <input type="number"
                               name="alat[{{ $loop->index }}][jumlah]"
                               id="jumlah_{{ $a->id_alat }}"
                               min="1"
                               max="{{ $a->stok }}"
                               value="{{ old('alat.'.$loop->index.'.jumlah', 1) }}"
                               class="w-full border border-gray-300 p-2 rounded-lg text-center jumlah-input"
                               placeholder="Jumlah"
                               disabled
                               data-max="{{ $a->stok }}"
                               oninput="validateJumlah(this)">
                        <span class="text-sm text-gray-500 whitespace-nowrap">
                            max: {{ $a->stok }}
                        </span>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Info Selected dan Summary -->
<div class="mt-4 space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-blue-800">
                        <span id="selected-count" class="font-bold text-lg">0</span> alat dipilih
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-green-800">
                        Total item: <span id="total-jumlah" class="font-bold">0</span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="text-sm text-gray-600">
            <p>Pastikan semua data sudah benar sebelum disimpan</p>
        </div>
    </div>
    
    <!-- Validasi Error -->
    <div id="error-message" class="hidden p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center gap-2 text-red-800">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span id="error-text"></span>
        </div>
    </div>
</div>

<!-- Button Simpan -->
<div class="mt-6 flex justify-end gap-3">
    <a href="{{ route('admin.peminjaman.index') }}" 
       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
        Batal
    </a>
    <button type="submit" 
            id="submit-btn"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
        </svg>
        Simpan Peminjaman
    </button>
</div>
@endif

</form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.alat-checkbox');
    const jumlahInputs = document.querySelectorAll('.jumlah-input');
    const selectedCount = document.getElementById('selected-count');
    const totalJumlah = document.getElementById('total-jumlah');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    const submitBtn = document.getElementById('submit-btn');
    const form = document.getElementById('form-peminjaman');
    
    // Update UI saat checkbox diklik
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const index = this.getAttribute('data-index');
            const jumlahInput = document.getElementById(`jumlah_${this.value}`);
            
            if (this.checked) {
                jumlahInput.disabled = false;
                jumlahInput.value = jumlahInput.value || 1;
                jumlahInput.focus();
            } else {
                jumlahInput.disabled = true;
                jumlahInput.value = '';
            }
            
            updateSummary();
            validateForm();
        });
    });
    
    // Validasi input jumlah
    function validateJumlah(input) {
        const max = parseInt(input.getAttribute('data-max'));
        const value = parseInt(input.value) || 0;
        
        if (value > max) {
            input.value = max;
            showError(`Jumlah tidak boleh melebihi stok tersedia (${max})`);
        } else if (value < 1) {
            input.value = 1;
            showError('Jumlah minimal 1');
        } else {
            hideError();
        }
        
        updateSummary();
        validateForm();
    }
    
    // Update summary informasi
    function updateSummary() {
        let selected = 0;
        let total = 0;
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selected++;
                const jumlahInput = document.getElementById(`jumlah_${checkbox.value}`);
                const jumlah = parseInt(jumlahInput.value) || 0;
                total += jumlah;
            }
        });
        
        selectedCount.textContent = selected;
        totalJumlah.textContent = total;
    }
    
    // Validasi form sebelum submit
    function validateForm() {
        let hasError = false;
        let errorMsg = '';
        
        // Cek apakah ada alat yang dipilih
        const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
        if (checkedBoxes.length === 0) {
            hasError = true;
            errorMsg = 'Pilih minimal 1 alat untuk dipinjam';
        }
        
        // Cek validitas jumlah untuk setiap alat yang dipilih
        checkedBoxes.forEach(checkbox => {
            const jumlahInput = document.getElementById(`jumlah_${checkbox.value}`);
            const jumlah = parseInt(jumlahInput.value) || 0;
            const max = parseInt(jumlahInput.getAttribute('data-max'));
            
            if (jumlah < 1) {
                hasError = true;
                errorMsg = 'Jumlah minimal 1 untuk setiap alat';
            } else if (jumlah > max) {
                hasError = true;
                errorMsg = `Jumlah melebihi stok tersedia untuk alat tertentu`;
            }
        });
        
        if (hasError) {
            showError(errorMsg);
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            hideError();
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        return !hasError;
    }
    
    // Tampilkan error
    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
    }
    
    // Sembunyikan error
    function hideError() {
        errorMessage.classList.add('hidden');
    }
    
    // Handle form submit
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            showError('Harap perbaiki kesalahan sebelum menyimpan');
        }
    });
    
    // Auto-check jumlah input saat diketik
    jumlahInputs.forEach(input => {
        input.addEventListener('input', function() {
            validateJumlah(this);
        });
        
        input.addEventListener('blur', function() {
            if (this.value === '' || this.value === '0') {
                this.value = 1;
                validateJumlah(this);
            }
        });
    });
    
    // Pilih semua checkbox (opsional, bisa ditambahkan tombol)
    function selectAll() {
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    }
    
    // Unselect all (opsional)
    function unselectAll() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change'));
        });
    }
    
    // Inisialisasi
    updateSummary();
    validateForm();
    
    // Tambahkan event listener untuk filter real-time
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.closest('form').submit();
            }, 800);
        });
    }
    
    // Auto-submit filter dropdown
    const filterSelects = document.querySelectorAll('select[name="kategori"], select[name="kondisi"], select[name="status"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
});
</script>
@endpush
@endsection
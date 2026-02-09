@extends('layouts.peminjam')

@section('title', 'Ajukan Peminjaman')
@section('header', 'Ajukan Peminjaman')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    {{-- NOTIF --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTER --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <input type="text"
               id="searchInput"
               placeholder="Cari nama alat..."
               class="border p-2 rounded w-full">

        <select id="kategoriFilter" class="border p-2 rounded">
            <option value="">Semua Kategori</option>
            @foreach ($kategori as $kat)
                <option value="{{ $kat->id_kategori }}">
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="font-semibold">Tanggal Kembali Rencana</label>
            <input type="date"
                   name="tanggal_kembali_rencana"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        {{-- GRID ALAT --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="alatContainer">

            @foreach ($alat as $item)
            <div class="border rounded-lg p-4 alat-card"
                 data-nama="{{ strtolower($item->nama_alat) }}"
                 data-kategori="{{ $item->id_kategori }}">

                <img src="{{ asset('storage/'.$item->gambar) }}"
                     class="h-64 w-64 object-cover rounded mb-3">

                <h3 class="font-semibold">{{ $item->nama_alat }}</h3>
                <p class="text-sm text-gray-500 mb-2">
                    {{ $item->kategori->nama_kategori }}
                </p>

                <p class="text-sm mb-2">Stok: {{ $item->stok }}</p>

                <div class="flex items-center gap-3">
                    <input type="checkbox"
                           name="alat[{{ $item->id_alat }}]"
                           value="{{ $item->id_alat }}"
                           onchange="toggleJumlah(this)">

                    <input type="number"
                           name="jumlah[{{ $item->id_alat }}]"
                           min="1"
                           max="{{ $item->stok }}"
                           class="border p-1 w-20"
                           placeholder="Jumlah"
                           disabled>
                </div>
            </div>
            @endforeach

        </div>

        <div class="mt-6 justify-end flex">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Ajukan Peminjaman
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
function toggleJumlah(checkbox) {
    const qty = checkbox.parentElement.querySelector('input[type="number"]');
    qty.disabled = !checkbox.checked;
    if (!checkbox.checked) qty.value = '';
}

// SEARCH
document.getElementById('searchInput').addEventListener('input', function () {
    const val = this.value.toLowerCase();
    document.querySelectorAll('.alat-card').forEach(card => {
        card.style.display = card.dataset.nama.includes(val) ? 'block' : 'none';
    });
});

// FILTER KATEGORI
document.getElementById('kategoriFilter').addEventListener('change', function () {
    const val = this.value;
    document.querySelectorAll('.alat-card').forEach(card => {
        card.style.display = (!val || card.dataset.kategori === val) ? 'block' : 'none';
    });
});
</script>

@endsection

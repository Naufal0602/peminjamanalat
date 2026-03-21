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
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alat..."
                    class="border p-2 rounded w-full">

                <select name="kategori" class="border p-2 rounded">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}"
                            {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <button class="bg-blue-500 text-white rounded px-4">Filter</button>
            </form>
        </div>

        <form id="formPeminjaman" action="{{ route('peminjam.peminjaman.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="font-semibold">Tanggal Kembali Rencana</label>
                <input type="date" name="tanggal_kembali_rencana" class="w-full border p-2 rounded" required>
            </div>

            {{-- GRID ALAT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="alatContainer">

                @foreach ($alat as $item)
                    <div class="border rounded-xl p-4 shadow-sm hover:shadow-md transition">

                        <img src="{{ asset('storage/' . $item->gambar) }}" class="h-70 w-70 object-cover rounded mb-3">

                        <h3 class="font-semibold text-lg">{{ $item->nama_alat }}</h3>

                        <p class="text-sm text-gray-500 mb-2">
                            {{ $item->kategori->nama_kategori }}
                        </p>

                        <p class="text-sm mb-2">Stok:
                            <span class="font-semibold text-blue-600">{{ $item->stok }}</span>
                        </p>

                        <div class="flex items-center gap-3 mt-3">
                            <input type="checkbox" name="alat[{{ $item->id_alat }}]" onchange="toggleJumlah(this)">

                            <input type="number" name="jumlah[{{ $item->id_alat }}]" min="1"
                                max="{{ $item->stok }}" class="border p-1 w-20 rounded" placeholder="Jumlah" disabled>
                        </div>
                    </div>
                @endforeach
                <div class="mt-6 flex justify-center">
                    {{ $alat->links() }}
                </div>
            </div>

            <div class="mt-6 justify-end flex">
                <button type="button" onclick="confirmSubmit()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>

    {{-- SCRIPT --}}
    @push('scripts')
<script>
function toggleJumlah(checkbox) {
    const qty = checkbox.parentElement.querySelector('input[type="number"]');
    qty.disabled = !checkbox.checked;

    if (checkbox.checked) {
        qty.focus(); // 🔥 langsung fokus biar bisa ngetik
    } else {
        qty.value = '';
    }
}

// VALIDASI QTY
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('input', function () {
        let max = parseInt(this.max);
        let value = parseInt(this.value);

        if (value > max) {
            this.value = max;
            Swal.fire({
                icon: 'warning',
                title: 'Melebihi Stok!',
                text: 'Jumlah tidak boleh lebih dari stok',
            });
        }

        if (value < 1) {
            this.value = 1;
        }
    });
});

// SWEET ALERT SUBMIT
function confirmSubmit() {
    Swal.fire({
        title: 'Ajukan Peminjaman?',
        text: "Pastikan alat & jumlah sudah benar!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Ajukan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPeminjaman').submit();
        }
    });
}
</script>
@endpush
@endsection

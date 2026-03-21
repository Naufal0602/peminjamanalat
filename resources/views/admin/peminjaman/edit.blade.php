@extends('layouts.admin')

@section('header', 'Edit Peminjaman')

@section('content')
    <div class="flex justify-center items-center min-h-[70vh]">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-xl">

            <h2 class="text-xl font-bold text-gray-700 mb-6 text-center">
                Edit Peminjaman
            </h2>

            <form id="formEdit" method="POST" action="{{ route('admin.peminjaman.update', $peminjaman->id_peminjaman) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Tanggal Pinjam
                    </label>
                    <input type="date" name="tanggal_pinjam" value="{{ $peminjaman->tanggal_pinjam }}"
                        class="w-full border border-gray-300 focus:ring focus:ring-blue-200 p-2 rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Tanggal Kembali Rencana
                    </label>
                    <input type="date" name="tanggal_kembali_rencana" value="{{ $peminjaman->tanggal_kembali_rencana }}"
                        class="w-full border border-gray-300 focus:ring focus:ring-blue-200 p-2 rounded-lg">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Status
                    </label>
                    <select name="status"
                        class="w-full border border-gray-300 focus:ring focus:ring-blue-200 p-2 rounded-lg">
                        <option value="menunggu" {{ $peminjaman->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ $peminjaman->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="selesai" {{ $peminjaman->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.peminjaman.index') }}" class="text-white bg-red-600 hover:bg-red-700 px-5 py-2 rounded-lg text-sm">
                        ← Batal
                    </a>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#formEdit').submit(function(e) {
                e.preventDefault();

                let form = this;

                Swal.fire({
                    title: "Yakin ingin update?",
                    text: "Data peminjaman akan diperbarui!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, update!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@endsection

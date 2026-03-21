@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori')

@section('content')

<div class="flex justify-center">
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg border">

        <div class="mb-4 border-b pb-3">
            <h2 class="text-xl font-bold text-gray-700">
                📁 Tambah Kategori Baru
            </h2>
            <p class="text-sm text-gray-500">
                Silahkan masukkan nama kategori alat
            </p>
        </div>

        <form action="{{ route('admin.kategori.store') }}" method="POST" id="formKategori">
            @csrf

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">
                    Nama Kategori
                </label>

                <input type="text"
                       name="nama_kategori"
                       class="w-full border p-3 rounded-lg focus:ring focus:ring-blue-200"
                       placeholder="Contoh: Alat Laboratorium"
                       value="{{ old('nama_kategori') }}"
                       required>
            </div>

            <div class="flex gap-3">

                <!-- tombol simpan -->
                <button type="button"
                        id="btnSimpan"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                     Simpan
                </button>

                <a href="{{ route('admin.kategori.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow">
                    ← Kembali
                </a>

            </div>

        </form>

    </div>
</div>

@endsection


@push('scripts')
    
<script>

document.getElementById('btnSimpan').addEventListener('click', function(){

    Swal.fire({
        title: "Simpan kategori?",
        text: "Pastikan data sudah benar!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Simpan",
        cancelButtonText: "Batal"
    }).then((result) => {

        if (result.isConfirmed) {
            document.getElementById('formKategori').submit();
        }

    });

});

</script>
@endpush

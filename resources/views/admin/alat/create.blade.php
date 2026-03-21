@extends('layouts.admin')

@section('title', 'Tambah Alat')
@section('header', 'Tambah Alat')

@section('content')

    <div class="flex justify-center">
        <div class="bg-white p-6 rounded-xl shadow-lg border w-full max-w-2xl">

            <div class="border-b pb-3 mb-6">
                <h2 class="text-xl font-semibold text-gray-700">
                    Tambah Data Alat
                </h2>
                <p class="text-sm text-gray-500">
                    Masukkan data alat yang akan ditambahkan
                </p>
            </div>

            <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" id="formTambahAlat">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- kategori --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kategori</label>

                        <select name="id_kategori" id="kategori" class="w-full border rounded-lg p-2">

                            <option value="">Pilih kategori</option>

                            @foreach ($kategori as $item)
                                <option value="{{ $item->id_kategori }}">
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- nama alat --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Alat</label>

                        <input type="text" name="nama_alat"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-300"
                            placeholder="Masukkan nama alat">
                    </div>

                    {{-- stok --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Stok</label>

                        <input type="number" name="stok"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-300" placeholder="Jumlah stok">
                    </div>

                    {{-- kondisi --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kondisi</label>

                        <select name="kondisi" class="w-full border rounded-lg p-2">
                            <option value="">Pilih kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                </div>

                {{-- upload gambar --}}
                <div class="mt-5">

                    <label class="block text-sm font-semibold mb-2">
                        Gambar Alat
                    </label>

                    <input type="file" name="gambar" id="gambarInput" accept="image/*"
                        class="w-full border rounded-lg p-2">

                    {{-- preview --}}
                    <div class="mt-3">
                        <img id="previewGambar" class="hidden w-40 rounded-lg border shadow">
                    </div>

                </div>

                {{-- tombol --}}
                <div class="flex gap-3 mt-6">

                    <button type="button" id="btnSimpanAlat"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                        Simpan

                    </button>

                    <a href="{{ route('admin.alat.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow">

                        ← Kembali

                    </a>

                </div>

            </form>

        </div>
    </div>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // searchable kategori
                new TomSelect("#kategori", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });


                // preview gambar
                const gambarInput = document.getElementById("gambarInput");
                const preview = document.getElementById("previewGambar");

                gambarInput.addEventListener("change", function() {

                    const file = this.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.classList.remove("hidden");
                        }

                        reader.readAsDataURL(file);
                    }

                });


                // konfirmasi simpan
                document.getElementById("btnSimpanAlat").addEventListener("click", function() {

                    Swal.fire({
                        title: "Simpan data alat?",
                        text: "Pastikan data sudah benar",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Simpan",
                        cancelButtonText: "Batal"
                    }).then((result) => {

                        if (result.isConfirmed) {
                            document.getElementById("formTambahAlat").submit();
                        }

                    });

                });

            });
        </script>
    @endpush
@endsection

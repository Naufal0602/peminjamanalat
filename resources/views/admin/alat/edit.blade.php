@extends('layouts.admin')

@section('title', 'Edit Alat')
@section('header', 'Edit Alat')

@section('content')

    <div class="flex justify-center">
        <div class="bg-white w-full max-w-2xl p-6 rounded-xl shadow-lg border">

            <div class="border-b pb-3 mb-6">
                <h2 class="text-xl font-semibold text-gray-700">
                    Edit Data Alat
                </h2>
                <p class="text-sm text-gray-500">
                    Perbarui data alat yang tersedia
                </p>
            </div>

            <form action="{{ route('admin.alat.update', $alat->id_alat) }}" method="POST" enctype="multipart/form-data"
                id="formEditAlat">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- kategori --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kategori</label>

                        <select name="id_kategori" id="kategori" class="w-full border rounded-lg p-2">

                            @foreach ($kategori as $item)
                                <option value="{{ $item->id_kategori }}"
                                    {{ $alat->id_kategori == $item->id_kategori ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- nama alat --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Nama Alat</label>

                        <input type="text" name="nama_alat" value="{{ $alat->nama_alat }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-300">
                    </div>

                    {{-- stok --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Stok</label>

                        <input type="number" name="stok" value="{{ $alat->stok }}"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-300">
                    </div>

                    {{-- kondisi --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Kondisi</label>

                        <select name="kondisi" class="w-full border rounded-lg p-2">

                            <option value="baik" {{ $alat->kondisi == 'baik' ? 'selected' : '' }}>
                                Baik
                            </option>

                            <option value="rusak_ringan" {{ $alat->kondisi == 'rusak_ringan' ? 'selected' : '' }}>
                                Rusak Ringan
                            </option>

                            <option value="rusak_berat" {{ $alat->kondisi == 'rusak_berat' ? 'selected' : '' }}>
                                Rusak Berat
                            </option>

                        </select>
                    </div>

                </div>

                {{-- gambar --}}
                <div class="mt-5">

                    <label class="block text-sm font-semibold mb-2">
                        Gambar Alat
                    </label>

                    <input type="file" name="gambar" id="gambarInput" accept="image/*"
                        class="w-full border rounded-lg p-2">

                    <div class="flex gap-4 mt-3">

                        {{-- gambar lama --}}
                        @if ($alat->gambar)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Gambar lama</p>
                                <img src="{{ asset('storage/' . $alat->gambar) }}" class="w-32 rounded border shadow">
                            </div>
                        @endif

                        {{-- preview gambar baru --}}
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Preview gambar baru</p>
                            <img id="previewGambar" class="hidden w-32 rounded border shadow">
                        </div>

                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" id="btnUpdate"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">

                        Update

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


                // preview gambar baru
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


                // konfirmasi update
                document.getElementById("btnUpdate").addEventListener("click", function() {

                    Swal.fire({
                        title: "Update data alat?",
                        text: "Perubahan akan disimpan",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Update",
                        cancelButtonText: "Batal"
                    }).then((result) => {

                        if (result.isConfirmed) {
                            document.getElementById("formEditAlat").submit();
                        }

                    });

                });

            });
        </script>
    @endpush
@endsection

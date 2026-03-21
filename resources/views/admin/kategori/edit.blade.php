@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('header', 'Edit Kategori')

@section('content')

<div class="flex justify-center">
    <div class="bg-white border rounded-xl shadow-lg w-full max-w-lg p-6">

        <div class="border-b pb-3 mb-5">
            <h2 class="text-xl font-semibold text-gray-700">
                Edit Kategori
            </h2>
            <p class="text-sm text-gray-500">
                Ubah nama kategori alat yang tersedia
            </p>
        </div>

        <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}"
              method="POST"
              id="formUpdateKategori">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Kategori
                </label>

                <input type="text"
                       name="nama_kategori"
                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                       class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-300"
                       placeholder="Masukkan nama kategori"
                       required>
            </div>

            <div class="flex gap-3">

                <button type="button"
                        id="btnUpdate"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
                    Update
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.getElementById('btnUpdate').addEventListener('click', function(){

    Swal.fire({
        title: 'Update kategori?',
        text: "Perubahan akan disimpan.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Update',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            document.getElementById('formUpdateKategori').submit();
        }

    });

});

</script>

@endpush
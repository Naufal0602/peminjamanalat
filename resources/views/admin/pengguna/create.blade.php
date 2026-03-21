@extends('layouts.admin')

@section('title', 'Tambah Petugas')
@section('header', 'Tambah Petugas')

@section('content')
    <div class="flex justify-center items-center min-h-[70vh]">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg">

            <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
                Tambah Petugas
            </h2>

            <form id="formTambah" action="{{ route('admin.pengguna.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-600">Nama</label>
                    <input type="text" name="name"
                        class="w-full border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 rounded-lg"
                        placeholder="Masukkan nama..." required>
                </div>

                <div class="mb-4">
                    <label class="block mb-1 text-sm font-medium text-gray-600">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 rounded-lg"
                        placeholder="Masukkan email..." required>
                </div>

                <div class="mb-6">
                    <label class="block mb-1 text-sm font-medium text-gray-600">Password</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-2 rounded-lg"
                        placeholder="Minimal 6 karakter..." required>
                </div>

                <input type="hidden" name="role" value="petugas">

                <div class="flex justify-between items-center">
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="text-white bg-red-600 hover:bg-red-700 text-sm py-2 px-4 rounded-lg">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-2 rounded-lg shadow">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#formTambah').submit(function(e) {
                e.preventDefault();

                let form = this;

                Swal.fire({
                    title: "Yakin ingin menyimpan?",
                    text: "Data petugas akan ditambahkan!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, simpan!",
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

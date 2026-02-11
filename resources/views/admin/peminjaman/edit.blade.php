@extends('layouts.admin')

@section('header','Edit Peminjaman')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-xl">

<form method="POST"
      action="{{ route('admin.peminjaman.update',$peminjaman->id_peminjaman) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Tanggal Pinjam</label>
    <input type="date"
           name="tanggal_pinjam"
           value="{{ $peminjaman->tanggal_pinjam }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label>Tanggal Kembali Rencana</label>
    <input type="date"
           name="tanggal_kembali_rencana"
           value="{{ $peminjaman->tanggal_kembali_rencana }}"
           class="w-full border p-2 rounded">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="w-full border p-2 rounded">
        <option value="menunggu" {{ $peminjaman->status=='menunggu'?'selected':'' }}>
            Menunggu
        </option>
        <option value="disetujui" {{ $peminjaman->status=='disetujui'?'selected':'' }}>
            Disetujui
        </option>
        <option value="ditolak" {{ $peminjaman->status=='ditolak'?'selected':'' }}>
            Ditolak
        </option>
        <option value="selesai" {{ $peminjaman->status=='selesai'?'selected':'' }}>
            Selesai
        </option>
    </select>
</div>

    <button class="bg-blue-600 text-white px-5 py-2 rounded">
        Update
    </button>
    <button>
        <a href="{{ route('admin.peminjaman.index') }}" class="text-white px-5 py-2 rounded" style="background-color: grey;">
            Batal
        </a>
    </button>
</form>
</div>
@endsection

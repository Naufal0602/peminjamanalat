@extends('layouts.petugas')

@section('title', 'Peminjaman Menunggu')
@section('header', 'Peminjaman Menunggu')

@section('content')

<div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white mb-6">
    <h1 class="text-2xl font-bold">Daftar Peminjaman</h1>
    <p>Menunggu persetujuan petugas</p>
</div>

<div class="bg-white rounded-xl shadow p-6">

    @if ($peminjaman->isEmpty())
        <p class="text-gray-500 text-center">Tidak ada peminjaman menunggu.</p>
    @else

    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Noo</th>
                    <th class="border px-3 py-2">Peminjam</th>
                    <th class="border px-3 py-2">Tanggal Pinjam</th>
                    <th class="border px-3 py-2">Detail Alat</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman as $item)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="border px-3 py-2">{{ $item->peminjam->name }}</td>
                    <td class="border px-3 py-2 text-center">
                        {{ $item->tanggal_pinjam }}
                    </td>
                    <td class="border px-3 py-2">
                        <ul class="list-disc pl-4">
                            @foreach ($item->detailPeminjaman as $detail)
                                <li>
                                    {{ $detail->alat->nama_alat }}
                                    ({{ $detail->jumlah }})
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="border px-3 py-2 text-center">
                        @if ($item->status === 'menunggu')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">
                                Menunggu
                            </span>
                        @elseif ($item->status === 'disetujui')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                Disetujui
                            </span>
                        @endif
                    </td>
                    <td class="border px-3 py-2 flex gap-2 justify-center">

                        {{-- JIKA STATUS MENUNGGU --}}
                        @if ($item->status === 'menunggu')

                            <form action="{{ route('petugas.peminjaman.setujui', $item->id_peminjaman) }}"
                                method="POST">
                                @csrf
                                <button
                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('petugas.peminjaman.tolak', $item->id_peminjaman) }}"
                                method="POST">
                                @csrf
                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                    Tolak
                                </button>
                            </form>

                        {{-- JIKA STATUS DISETUJUI --}}
                        @elseif ($item->status === 'disetujui')

                            <form action="{{ route('petugas.peminjaman.serahkan', $item->id_peminjaman) }}"
                                method="POST">
                                @csrf
                                <button
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                    Alat Diambil
                                </button>
                            </form>

                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif

</div>

@endsection

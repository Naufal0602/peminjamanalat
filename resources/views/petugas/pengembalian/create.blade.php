@extends('layouts.petugas')

@section('title', 'Proses Pengembalian')
@section('header', 'Proses Pengembalian')

@section('content')

<form action="{{ route('petugas.pengembalian.store', $peminjaman->id_peminjaman) }}"
      method="POST">
@csrf

<div class="bg-white rounded-xl shadow p-6">

    <p class="mb-4 text-sm">
        <strong>Peminjam:</strong> {{ $peminjaman->peminjam->name }} <br>
        <strong>Tanggal Kembali Rencana:</strong> {{ $peminjaman->tanggal_kembali_rencana }}
    </p>

    @php
        $tanggalHarusKembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->startOfDay();
        $hariSekarang = now()->startOfDay();

        $hariTelat = 0;
        if ($hariSekarang->gt($tanggalHarusKembali)) {
            $hariTelat = $tanggalHarusKembali->diffInDays($hariSekarang);
        }
    @endphp

    <p class="mb-4 text-sm">
        <strong>Keterlambatan:</strong>
        <span class="text-red-600 font-semibold">
            {{ $hariTelat }} hari
        </span>
        (Rp 2.000 / hari)
    </p>

    {{-- DATATABLE --}}
    <div class="overflow-x-auto">
        <table id="datatable" class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Denda Kerusakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPeminjaman as $detail)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('storage/'.$detail->alat->gambar) }}"
                                 class="w-14 h-14 object-cover rounded">
                            <div>
                                <p class="font-semibold">{{ $detail->alat->nama_alat }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="text-center">
                        <input type="number"
                               name="jumlah[{{ $detail->id_alat }}]"
                               value="{{ $detail->jumlah }}"
                               readonly
                               class="border p-1 w-20">
                    </td>

                    <td>
                        <select name="kondisi[{{ $detail->id_alat }}]"
                                class="border p-1 kondisi-select"
                                data-harga="{{ $detail->alat->harga ?? 0 }}"
                                data-alat="{{ $detail->id_alat }}">
                            <option value="baik">Baik</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </td>

                  <td>
                        <input type="text"
                            id="denda-rp-{{ $detail->id_alat }}"
                            class="border p-1 w-32 bg-gray-100 denda-rp"
                            placeholder="Rp 0"
                            disabled>

                        <input type="hidden"
                            name="denda[{{ $detail->id_alat }}]"
                            id="denda-{{ $detail->id_alat }}"
                            value="0">
                 </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- TOTAL DENDA --}}
    <div class="mt-6 text-right">
        <p class="text-sm">
            <strong>Denda Keterlambatan:</strong>
            Rp {{ number_format($hariTelat * 2000) }}
        </p>

        <p class="text-lg font-bold">
            Total Denda:
            <span id="totalDenda">
                Rp {{ number_format($hariTelat * 2000) }}
            </span>
        </p>
    </div>

    <div class="mt-6">
        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Selesaikan Pengembalian
        </button>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
    const dendaPerHari = 2000;
    const hariTelat = {{ $hariTelat }};
    const dendaTelat = hariTelat * dendaPerHari;

    // FORMAT RUPIAH
    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function hitungTotal() {
        let total = dendaTelat;

        document.querySelectorAll('.kondisi-select').forEach(select => {
            const idAlat = select.dataset.alat;

            const dendaHidden = document.getElementById('denda-' + idAlat);
            const dendaRp = document.getElementById('denda-rp-' + idAlat);

            let nilai = parseInt(dendaHidden.value || 0);

            if (select.value === 'baik') {
                dendaHidden.value = 0;
                dendaRp.value = formatRupiah(0);
                dendaRp.disabled = true;
            } else {
                dendaRp.disabled = false;
                total += nilai;
            }
        });

        document.getElementById('totalDenda').innerText = formatRupiah(total);
    }

    // INPUT RUPIAH → ANGKA
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('denda-rp')) {
            const idAlat = e.target.id.replace('denda-rp-', '');
            const hidden = document.getElementById('denda-' + idAlat);

            let angka = e.target.value.replace(/[^0-9]/g, '');
            angka = parseInt(angka || 0);

            hidden.value = angka;
            e.target.value = formatRupiah(angka);

            hitungTotal();
        }
    });

    // KONDISI
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('kondisi-select')) {
            hitungTotal();
        }
    });

    // INIT
    document.addEventListener('DOMContentLoaded', hitungTotal);
</script>

@endpush

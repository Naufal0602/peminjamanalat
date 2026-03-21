<div class="bg-[#050706] text-white w-64 flex flex-col">
    <div class="p-4 flex items-center border-b border-gray-700">
        <i class="fas fa-tools text-blue-400 text-2xl mr-3"></i>
        <h1 class="text-xl font-bold">Petugas Dashboard</h1>
    </div>

    <nav class="flex-1 py-4">
        <ul class="space-y-1 px-3">
            <li>
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-chart-line mr-3"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-clipboard-list mr-3"></i> Peminjaman
                </a>
            </li>

            <li>
                <a href="{{ route('petugas.pengembalian.index') }}"
                    class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-undo mr-3"></i> Pengembalian
                </a>
            </li>

            <li>
                <a href="{{ route('petugas.laporan.index') }}"
                    class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-chart-bar mr-3"></i> Laporan
                </a>
            </li>

            <li>
                <a href="{{ route('profile.edit') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-user mr-3"></i> Profil
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="button" onclick="confirmLogout()" class="w-full text-left p-3 hover:bg-gray-800 rounded-lg">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </button>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin mau logout?',
                text: "Kamu akan keluar dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
@endpush

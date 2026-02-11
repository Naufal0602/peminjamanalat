<div class="bg-[#050706] text-white w-64 flex flex-col">
    <div class="p-4 flex items-center border-b border-gray-700">
        <i class="fas fa-tools text-blue-400 text-2xl mr-3"></i>
        <h1 class="text-xl font-bold">Alat Lab Admin</h1>
    </div>

    <nav class="flex-1 py-4">
        <ul class="space-y-1 px-3">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-home mr-3"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.pengguna.index') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-users mr-3"></i> Pengguna
                </a>
            </li>

            <li>
                <a href="{{ route('admin.alat.index') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-toolbox mr-3"></i> Alat
                </a>
            </li>

              <li>
                <a href="{{ route('admin.kategori.index') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-toolbox mr-3"></i> Kategori
                </a>
            </li>

              <li>
                <a href="{{ route('admin.log_aktivitas.index') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-toolbox mr-3"></i> log aktivitas
                </a>
            </li>
              <li>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-toolbox mr-3"></i> Profil
                </a>
            </li>
              <li>
                <a href="{{ route('admin.peminjaman.index') }}"
                   class="flex items-center p-3 rounded-lg hover:bg-gray-800">
                    <i class="fas fa-toolbox mr-3"></i> Peminjaman
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-4 border-t border-gray-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left p-3 hover:bg-gray-800 rounded-lg">
                <i class="fas fa-sign-out-alt mr-3"></i> Logout
            </button>
        </form>
    </div>
</div>

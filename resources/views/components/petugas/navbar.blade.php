<header class="bg-white shadow-sm border-b">
    <div class="flex items-center justify-between p-4">
        <h2 class="text-xl font-semibold text-gray-800">
            @yield('header', 'Dashboard')
        </h2>

        <div class="flex items-center space-x-3">
            <span class="text-gray-600">
                {{ auth()->user()->name ?? 'Petugas' }}
            </span>
            <i class="fas fa-user-circle text-2xl text-gray-600"></i>
        </div>
    </div>
</header>

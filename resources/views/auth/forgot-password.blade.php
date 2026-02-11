<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Lupa Password</h2>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Masukkan email yang terdaftar, dan kami akan mengirimkan link reset password ke email Anda. Klik link tersebut untuk membuat password baru.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
        <div>
            <span class="text-white">Kembali ke</span> <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">halaman login</a>
        </div>
    </form>
</x-guest-layout>

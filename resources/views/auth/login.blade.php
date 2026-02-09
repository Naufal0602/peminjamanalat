<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name') }}</title>

    <!-- Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Poppins'] min-h-screen flex items-center justify-center" style="background-image: url('{{ asset('images/auth/bglogin.png') }}');
         background-size: cover;
         background-position: center;
         background-repeat: no-repeat;">

    <!-- CARD -->
    <div class="w-full max-w-6xl bg-[#c5ece0] rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <!-- LEFT -->
        <div class="hidden md:flex items-center justify-center bg-[#ffffff]">
            <img
                src="{{ asset('images/ui/login-ui.svg') }}"
                alt="Login Illustration"
                class="w-4/5"
            >
        </div>

        <!-- RIGHT -->
        <div class="p-10 md:p-14">
            <div class="text-center justify-center">
                <h1 class="text-3xl font-semibold text-gray-800 mb-2">Login</h1>
                 <p class="text-gray-500 mb-8">Silakan masuk ke sistem</p>
            </div>
            

            <!-- SESSION STATUS -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- USERNAME / EMAIL -->
                <div class="mb-5">
                    <label class="text-sm text-gray-500">Email / Username</label>
                    <input
                        type="text"
                        name="email"
                        class="w-full mt-2 rounded-xl bg-gray-100 border-0 focus:ring-2 focus:ring-emerald-600"
                        placeholder="Masukkan username"
                        required
                        autofocus
                    >
                    @error('email')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-6">
                    <label class="text-sm text-gray-500">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full mt-2 rounded-xl bg-gray-100 border-0 focus:ring-2 focus:ring-emerald-600"
                        placeholder="Masukkan password"
                        required
                    >
                    @error('password')
                        <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- FORGOT -->
                <div class="text-right mb-6">
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-emerald-700 hover:underline"
                    >
                        Forgot Password?
                    </a>
                </div>
                      <div class="text-right mb-6">
                    <a
                        href="{{ route('register') }}"
                        class="text-sm text-emerald-700 hover:underline"
                    >
                        belum punya akun? register disini
                    </a>
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full py-3 rounded-full bg-emerald-700 text-white font-semibold hover:bg-emerald-800 transition"
                >
                    Login
                </button>
            </form>

        </div>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Poppins'] antialiased">

    <!-- GLOBAL BACKGROUND -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#0f172a] via-[#020617] to-[#022c22] px-4">

        <!-- WRAPPER CARD (AMAN UNTUK SEMUA AUTH PAGE) -->
        <div class="w-full max-w-md sm:max-w-lg md:max-w-xl bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden">

            <div class="px-6 py-6 sm:px-10 sm:py-8">
                {{ $slot }}
            </div>

        </div>
    </div>

</body>
</html>

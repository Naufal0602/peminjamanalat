<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Profile</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        /* Custom Styles */
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
        }

        .back-button {
            transition: all 0.3s ease;
        }

        .back-button:hover {
            transform: translateX(-5px);
        }

        .profile-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #dc2626);
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        .avatar-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .avatar-upload:hover {
            transform: scale(1.1);
        }

        .tab-button {
            padding: 12px 24px;
            border-radius: 8px 8px 0 0;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            color: #6b7280;
            font-weight: 500;
        }

        .tab-button:hover {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .tab-button.active {
            background: white;
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }

        .dark .tab-button.active {
            background: #374151;
            color: white;
        }

        .dark .profile-card {
            background: #1f2937;
        }

        .dark .form-input {
            background: #374151;
            border-color: #4b5563;
            color: white;
        }

        .dark .form-input:focus {
            border-color: var(--primary-color);
            background: #374151;
            color: white;
        }

        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Success message animation */
        .alert-success {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Header dengan Tombol Kembali -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Tombol Kembali -->
                      <a href="{{ url()->previous() }}"
                            class="flex items-center space-x-2 p-3 text-gray-600 dark:text-gray-400 
                                    hover:text-gray-900 dark:hover:text-white 
                                    hover:bg-gray-50 dark:hover:bg-gray-700 
                                    rounded-lg transition-colors duration-200">
                                <i class="bi bi-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                    
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ __('Profile Settings') }}
                    </h1>
                </div>
                
                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('status') === 'profile-updated')
                <div id="successMessage" class="mb-6 alert-success p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg flex items-center space-x-3">
                    <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                    <span class="text-green-800 dark:text-green-200 font-medium">
                        {{ __('Profile updated successfully!') }}
                    </span>
                </div>
            @endif

            @if (session('status') === 'password-updated')
                <div id="successMessage" class="mb-6 alert-success p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg flex items-center space-x-3">
                    <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                    <span class="text-green-800 dark:text-green-200 font-medium">
                        {{ __('Password updated successfully!') }}
                    </span>
                </div>
            @endif

            <!-- Profile Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sidebar Profil -->
                <div class="lg:col-span-1">
                    <div class="profile-card bg-white dark:bg-gray-800 rounded-xl p-6 sticky top-6">
                        <!-- Avatar -->
                        <div class="mb-6">
                            <div class="avatar-container">
                                @if(Auth::user()->profile_photo_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="avatar-img">
                                @else
                                    <div class="avatar-img bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white text-4xl font-bold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="text-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ Auth::user()->name }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-1">
                                <i class="bi bi-envelope mr-2"></i>{{ Auth::user()->email }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400">
                                <i class="bi bi-calendar mr-2"></i>
                                Bergabung sejak {{ Auth::user()->created_at->format('M Y') }}
                            </p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="text-gray-600 dark:text-gray-400">
                                    <i class="bi bi-shield-check mr-2"></i>Status Akun
                                </span>
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm font-medium rounded-full">
                                    Verified
                                </span>
                            </div>
                        </div>

                        <!-- Navigation Tabs -->
                        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                            <nav class="flex space-x-1 overflow-x-auto">
                                <button onclick="showTab('profile')" 
                                        class="tab-button active" id="tabProfile">
                                    <i class="bi bi-person mr-2"></i>Profile
                                </button>
                                <button onclick="showTab('password')" 
                                        class="tab-button" id="tabPassword">
                                    <i class="bi bi-lock mr-2"></i>Password
                                </button>
                                <button onclick="showTab('danger')" 
                                        class="tab-button" id="tabDanger">
                                    <i class="bi bi-exclamation-triangle mr-2"></i>Danger
                                </button>
                            </nav>
                        </div>

                        <!-- Additional Actions -->
                        <div class="space-y-3">
                          <a href="{{ url()->previous() }}"
                            class="flex items-center space-x-2 p-3 text-gray-600 dark:text-gray-400 
                                    hover:text-gray-900 dark:hover:text-white 
                                    hover:bg-gray-50 dark:hover:bg-gray-700 
                                    rounded-lg transition-colors duration-200">
                                <i class="bi bi-arrow-left"></i>
                                <span>Kembali</span>
                            </a>

                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center space-x-2 p-3 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors duration-200">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Profile Information Tab -->
                    <div id="profileTab" class="profile-card bg-white dark:bg-gray-800 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <i class="bi bi-person-gear mr-2"></i>Profile Information
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Update your account's profile information and email address
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Active</span>
                            </div>
                        </div>

                        <!-- Update Profile Form -->
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <!-- Update Password Tab -->
                    <div id="passwordTab" class="profile-card bg-white dark:bg-gray-800 rounded-xl p-6 hidden">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <i class="bi bi-shield-lock mr-2"></i>Update Password
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Ensure your account is using a long, random password to stay secure
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="bi bi-patch-check-fill text-blue-500 text-xl"></i>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Secure</span>
                            </div>
                        </div>

                        <!-- Update Password Form -->
                        @include('profile.partials.update-password-form')
                    </div>

                    <!-- Danger Zone Tab -->
                    <div id="dangerTab" class="profile-card bg-white dark:bg-gray-800 rounded-xl p-6 hidden">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <i class="bi bi-exclamation-octagon mr-2"></i>Danger Zone
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Permanently delete your account
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-red-500 dark:text-red-400">Critical</span>
                            </div>
                        </div>

                        <!-- Warning Message -->
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex items-start space-x-3">
                                <i class="bi bi-exclamation-triangle-fill text-red-500 text-xl mt-1"></i>
                                <div>
                                    <h4 class="font-medium text-red-800 dark:text-red-300">
                                        Warning: Account Deletion
                                    </h4>
                                    <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                                        Once your account is deleted, all of its resources and data will be permanently deleted. 
                                        Before deleting your account, please download any data or information that you wish to retain.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Delete User Form -->
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-12 py-6 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-gray-600 dark:text-gray-400 text-sm">
                    © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </div>
                <div class="flex items-center space-x-6 text-sm">
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        Terms of Service
                    </a>
                    <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                        Help Center
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Fungsi untuk kembali ke halaman sebelumnya
        function goBack() {
            if (document.referrer && document.referrer !== window.location.href) {
                window.location.href = document.referrer;
            } else {
                window.location.href = '/dashboard';
            }
        }

        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tabs
            document.getElementById('profileTab').classList.add('hidden');
            document.getElementById('passwordTab').classList.add('hidden');
            document.getElementById('dangerTab').classList.add('hidden');
            
            // Remove active class from all tab buttons
            document.getElementById('tabProfile').classList.remove('active');
            document.getElementById('tabPassword').classList.remove('active');
            document.getElementById('tabDanger').classList.remove('active');
            
            // Show selected tab and activate its button
            document.getElementById(tabName + 'Tab').classList.remove('hidden');
            document.getElementById('tab' + tabName.charAt(0).toUpperCase() + tabName.slice(1)).classList.add('active');
            
            // Scroll to top of tab content
            document.getElementById(tabName + 'Tab').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Auto-hide success messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.remove();
                    }, 500);
                }, 5000);
            }

            // Avatar upload preview
            const avatarUpload = document.getElementById('avatar-upload');
            if (avatarUpload) {
                avatarUpload.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const avatarImg = document.querySelector('.avatar-img');
                            if (avatarImg.tagName === 'IMG') {
                                avatarImg.src = e.target.result;
                            } else {
                                // If it's a div, replace with img
                                const newImg = document.createElement('img');
                                newImg.src = e.target.result;
                                newImg.alt = 'Profile Photo';
                                newImg.className = 'avatar-img';
                                avatarImg.parentNode.replaceChild(newImg, avatarImg);
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Add loading state to form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !this.classList.contains('delete-form')) {
                        submitBtn.innerHTML = '<span class="loading-spinner"></span> Processing...';
                        submitBtn.disabled = true;
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Escape key to go back
                if (e.key === 'Escape') {
                    goBack();
                }
                
                // Ctrl + 1,2,3 for tab switching
                if (e.ctrlKey) {
                    switch(e.key) {
                        case '1':
                            e.preventDefault();
                            showTab('profile');
                            break;
                        case '2':
                            e.preventDefault();
                            showTab('password');
                            break;
                        case '3':
                            e.preventDefault();
                            showTab('danger');
                            break;
                    }
                }
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId !== '#') {
                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
                });
            });
        });

        // Dark mode toggle (optional enhancement)
        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark' || 
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>
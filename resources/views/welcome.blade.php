<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sekretariat Daerah Provinsi Kalimantan Timur</title>

    <!-- DaisyUI dan Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- AOS Animation Library -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @vite(['resources/css/welcome.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/js/animationClock.js')
</head>

<body class="antialiased light">
    <!-- Navbar with Glassmorphism -->
    <div class="navbar navbar-glass shadow-sm px-8 fixed top-0 z-50 transition-all duration-300">
        <!-- Bagian Kiri -->
        <div class="navbar-start">
            <div class="flex items-center gap-2 card-hover">
                <img src="{{ asset('images/kaltim.png') }}" alt="Logo SETDA Kaltim" class="h-12 w-auto">
                <div class="flex flex-col navbar-brand-text">
                    <h1 class="font-bold text-lg gradient-text">Sekretariat Daerah</h1>
                    <p class="text-sm text-gray-600">Provinsi Kalimantan Timur</p>
                </div>
            </div>
        </div>

        <!-- Clock in Center -->
        <div class="navbar-center hidden sm:block">
            <div class="clock-container">
                <div id="clock" class="clock-text text-lg"></div>
            </div>
        </div>

        <!-- Bagian Kanan -->
        <div class="navbar-end gap-2 sm:gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="auth-button login rounded-full">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="auth-button login rounded-full">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="auth-button register rounded-full">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero-pattern min-h-screen pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- Text Content with Animations -->
                <div class="space-y-6" data-aos="fade-right">
                    <h1 class="text-4xl md:text-5xl font-bold gradient-text leading-tight">
                        WEBSITE ABSENSI DIGITAL
                    </h1>
                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">
                        Biro Administrasi Pimpinan
                    </h2>
                    <p class="text-xl md:text-2xl font-medium text-gray-800 italic">
                        "Jejak Kehadiran yang Tak Bisa Dimanipulasi"
                    </p>
                    <p class="text-lg text-gray-600">
                        Meningkatkan transparansi dan tanggung jawab setiap pegawai
                    </p>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="stats-card p-4 rounded-lg shadow-lg card-hover" data-aos="fade-up"
                            data-aos-delay="100">
                            <div class="text-3xl font-bold text-blue-600">100%</div>
                            <div class="text-sm text-gray-600">Akurasi Kehadiran</div>
                        </div>
                        <div class="stats-card p-4 rounded-lg shadow-lg card-hover" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="text-3xl font-bold text-blue-600">Real-time</div>
                            <div class="text-sm text-gray-600">Monitoring</div>
                        </div>
                    </div>
                </div>

                <!-- Image with Floating Animation -->
                <div class="flex justify-center" data-aos="fade-left">
                    <img src="{{ asset('images/clock.png') }}" alt="Digital Clock"
                        class="w-full max-w-md h-auto floating">
                </div>
            </div>

            <!-- Features Section -->
            <div class="mt-20" data-aos="fade-up">
                <h3 class="text-2xl font-bold text-center mb-8 gradient-text">Fitur Unggulan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="stats-card p-6 rounded-lg shadow-lg card-hover">
                        <div class="text-blue-600 text-4xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Real-time Tracking</h4>
                        <p class="text-gray-600">Pantau kehadiran secara real-time dengan akurasi tinggi</p>
                    </div>
                    <div class="stats-card p-6 rounded-lg shadow-lg card-hover">
                        <div class="text-blue-600 text-4xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Keamanan Tinggi</h4>
                        <p class="text-gray-600">Sistem anti-manipulasi dengan teknologi terkini</p>
                    </div>
                    <div class="stats-card p-6 rounded-lg shadow-lg card-hover">
                        <div class="text-blue-600 text-4xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Laporan Lengkap</h4>
                        <p class="text-gray-600">Generate laporan detail untuk analisis kehadiran</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sekretariat Daerah Provinsi Kalimantan Timur</title>
        
        <!-- DaisyUI dan Tailwind -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {}
                }
            }
        </script>
        
        <!-- AOS Animation Library -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            :root {
                --background-light: #FFF5F6;
                --background-dark: #111827;
                --card-dark: #1f2937;
                --text-light: #1a1a1a;
                --text-dark: #f3f4f6;
                --accent-dark: #60a5fa;
                --gradient-dark-start: #1e40af;
                --gradient-dark-end: #3b82f6;
            }

            .dark {
                background: linear-gradient(to bottom right, var(--background-dark), #1a237e);
                color: var(--text-dark);
            }

            .light {
                background-color: var(--background-light);
                color: var(--text-light);
            }

            .hero-pattern {
                background-color: var(--background-light);
                position: relative;
                overflow: hidden;
            }

            .dark .hero-pattern {
                background: linear-gradient(to bottom right, var(--background-dark), #1a237e);
            }

            .decorative-pattern {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: auto;
                z-index: 0;
            }
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            @keyframes floating {
                0% { transform: translate(0, 0px); }
                50% { transform: translate(0, 15px); }
                100% { transform: translate(0, 0px); }
            }
            .gradient-text {
                background: linear-gradient(45deg, #1a365d, #2563eb);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }
            .stats-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.8);
            }
            .navbar-glass {
                background-color: rgba(255, 245, 246, 0.85);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            }
            .clock-container {
                background: rgba(255, 255, 255, 0.2);
                padding: 0.5rem 1.5rem;
                border-radius: 9999px;
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            
            .clock-text {
                background: linear-gradient(45deg, #2563eb, #1d4ed8);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                font-weight: 600;
                letter-spacing: 0.05em;
            }

            @media (max-width: 768px) {
                .clock-container {
                    padding: 0.25rem 1rem;
                }
                .clock-text {
                    font-size: 0.875rem;
                }
            }

            .auth-button {
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                padding: 0.5rem 1.5rem;
                font-weight: 500;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.025em;
                font-size: 0.875rem;
            }

            .auth-button:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-1px);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .auth-button.login {
                color: #2563eb;
            }

            .auth-button.register {
                color: #1e40af;
            }

            @media (max-width: 640px) {
                .auth-button {
                    padding: 0.375rem 1rem;
                    font-size: 0.75rem;
                }
                
                .navbar {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
                
                .navbar-brand-text {
                    display: none;
                }
            }

            @media (max-width: 768px) {
                .navbar-brand-text p {
                    display: none;
                }
            }

            .dark .navbar-glass {
                background-color: rgba(17, 24, 39, 0.85);
                border-bottom: 1px solid rgba(96, 165, 250, 0.1);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .dark .stats-card {
                background: rgba(31, 41, 55, 0.8);
                border: 1px solid rgba(96, 165, 250, 0.1);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .dark .gradient-text {
                background: linear-gradient(45deg, var(--accent-dark), #93c5fd);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .dark .text-gray-600 {
                color: #e5e7eb;
            }

            .dark .text-gray-800 {
                color: #f9fafb;
            } 

            .dark .auth-button {
                background: rgba(31, 41, 55, 0.6);
                color: var(--accent-dark);
                border: 1px solid rgba(96, 165, 250, 0.2);
                backdrop-filter: blur(8px);
            }

            .dark .auth-button:hover {
                background: rgba(31, 41, 55, 0.8);
                border-color: var(--accent-dark);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(96, 165, 250, 0.2);
            }

            .dark .clock-container {
                background: rgba(31, 41, 55, 0.6);
                border: 1px solid rgba(96, 165, 250, 0.2);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .dark .clock-text {
                background: linear-gradient(45deg, var(--accent-dark), #93c5fd);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .theme-toggle {
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                z-index: 50;
                padding: 0.75rem;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .theme-toggle:hover {
                transform: scale(1.1) rotate(8deg);
            }

            .dark .theme-toggle {
                background: rgba(31, 41, 55, 0.6);
                border: 1px solid rgba(96, 165, 250, 0.2);
                color: var(--accent-dark);
            }

            .dark .theme-toggle:hover {
                border-color: var(--accent-dark);
                box-shadow: 0 0 20px rgba(96, 165, 250, 0.3);
            }

            /* Card hover effects in dark mode */
            .dark .card-hover {
                transition: all 0.3s ease;
                border: 1px solid rgba(96, 165, 250, 0.1);
            }

            .dark .card-hover:hover {
                transform: translateY(-5px);
                border-color: var(--accent-dark);
                box-shadow: 0 10px 20px rgba(96, 165, 250, 0.1);
            }

            /* Feature cards in dark mode */
            .dark .stats-card svg {
                color: var(--accent-dark);
                filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.3));
            }

            /* Bottom image in dark mode */
            .dark img {
                filter: brightness(0.9) contrast(1.1);
                transition: all 0.3s ease;
            }

            .dark img:hover {
                filter: brightness(1) contrast(1.1);
            }

            /* Smooth theme transition */
            body {
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            /* Enhanced decorative pattern for dark mode */
            .dark .decorative-pattern {
                opacity: 0.1;
                mix-blend-mode: lighten;
            }
        </style>
    </head>
    
    <body class="antialiased light">
        <!-- Navbar with Glassmorphism -->
        <div class="navbar navbar-glass shadow-sm px-8 fixed top-0 z-50 transition-all duration-300">
            <!-- Bagian Kiri -->
            <div class="navbar-start">
                <div class="flex items-center gap-2 card-hover">
                    <img 
                        src="{{ asset('images/kaltim.png') }}" 
                        alt="Logo SETDA Kaltim" 
                        class="h-12 w-auto"
                    >
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
                        <a href="{{ route('login') }}" 
                           class="auth-button login rounded-full">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="auth-button register rounded-full">
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
                            <div class="stats-card p-4 rounded-lg shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                                <div class="text-3xl font-bold text-blue-600">100%</div>
                                <div class="text-sm text-gray-600">Akurasi Kehadiran</div>
                            </div>
                            <div class="stats-card p-4 rounded-lg shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                                <div class="text-3xl font-bold text-blue-600">Real-time</div>
                                <div class="text-sm text-gray-600">Monitoring</div>
                            </div>
                        </div>
                    </div>

                    <!-- Image with Floating Animation -->
                    <div class="flex justify-center" data-aos="fade-left">
                        <img 
                            src="{{ asset('images/clock.png') }}" 
                            alt="Digital Clock" 
                            class="w-full max-w-md h-auto floating"
                        >
                    </div>
                </div>

                <!-- Features Section -->
                <div class="mt-20" data-aos="fade-up">
                    <h3 class="text-2xl font-bold text-center mb-8 gradient-text">Fitur Unggulan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="stats-card p-6 rounded-lg shadow-lg card-hover">
                            <div class="text-blue-600 text-4xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold mb-2">Real-time Tracking</h4>
                            <p class="text-gray-600">Pantau kehadiran secara real-time dengan akurasi tinggi</p>
                        </div>
                        <div class="stats-card p-6 rounded-lg shadow-lg card-hover">
                            <div class="text-blue-600 text-4xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold mb-2">Keamanan Tinggi</h4>
                            <p class="text-gray-600">Sistem anti-manipulasi dengan teknologi terkini</p>
                        </div>
                        <div class="stats-card p-6 rounded-lg shadow-lg card-hover">
                            <div class="text-blue-600 text-4xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold mb-2">Laporan Lengkap</h4>
                            <p class="text-gray-600">Generate laporan detail untuk analisis kehadiran</p>
                        </div>
                    </div>
                </div>


        <!-- Theme Toggle Button -->
        <button class="theme-toggle" id="themeToggle" aria-label="Toggle Theme">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sun-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 moon-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <!-- AOS Animation Script -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            // Theme management
            function initializeTheme() {
                const savedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', savedTheme);
                document.body.classList.remove('light', 'dark');
                document.body.classList.add(savedTheme);
                updateThemeIcons(savedTheme);
            }

            function updateThemeIcons(theme) {
                const sunIcon = document.querySelector('.sun-icon');
                const moonIcon = document.querySelector('.moon-icon');
                if (theme === 'dark') {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                } else {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
            }

            function toggleTheme() {
                const isDark = document.body.classList.contains('dark');
                const newTheme = isDark ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', newTheme);
                document.body.classList.remove('light', 'dark');
                document.body.classList.add(newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIcons(newTheme);

                // Dispatch a custom event for theme change
                window.dispatchEvent(new CustomEvent('themeChanged', { detail: newTheme }));
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize AOS
                AOS.init({
                    duration: 800,
                    once: true,
                });

                // Initialize theme
                initializeTheme();
                
                // Theme toggle button click handler
                const themeToggle = document.getElementById('themeToggle');
                if (themeToggle) {
                    themeToggle.addEventListener('click', toggleTheme);
                }

                // Parallax Effect
                window.addEventListener('scroll', function() {
                    const scrolled = window.pageYOffset;
                    const parallaxElements = document.querySelectorAll('.decorative-pattern');
                    parallaxElements.forEach(element => {
                        element.style.transform = `translateY(${scrolled * 0.5}px)`;
                    });
                });

                // Real-time Clock Function
                function updateClock() {
                    const now = new Date();
                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const day = days[now.getDay()];
                    
                    let hours = now.getHours();
                    let minutes = now.getMinutes();
                    let seconds = now.getSeconds();

                    hours = hours < 10 ? '0' + hours : hours;
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;

                    const timeString = `${day}, ${hours}:${minutes}:${seconds} WITA`;
                    document.getElementById('clock').textContent = timeString;
                }

                updateClock();
                setInterval(updateClock, 1000);
            });
        </script>
    </body>
</html>
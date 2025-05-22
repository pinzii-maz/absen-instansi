<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sekretariat Daerah Provinsi Kalimantan Timur</title>
        
        <!-- DaisyUI dan Tailwind -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- AOS Animation Library -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            .hero-pattern {
                background-color: #FFF5F6;
                position: relative;
                overflow: hidden;
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
        </style>
    </head>
    
    <body class="antialiased bg-[#FFF5F6]">
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
                        <h1 class="font-bold text-lg gradient-text">Biro Administrasi Pimpinan</h1>
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
                        <p class="text-xl md:text-2xl font-medium text-gray-700 italic">
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

                <!-- Bottom Image with Parallax Effect -->
                <div class="mt-12" data-aos="zoom-in">
                    <img 
                        src="{{ asset('images/11.78.jpg') }}" 
                        alt="Bottom Decoration" 
                        class="w-full h-auto rounded-lg shadow-xl transform hover:scale-[1.02] transition-transform duration-300"
                    >
                </div>
            </div>

            <!-- Decorative Pattern -->
            <img 
                src="{{ asset('images/pattern.png') }}" 
                alt="Decorative Pattern" 
                class="decorative-pattern"
            >
        </div>

        <!-- AOS Animation Script -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true,
            });

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
                
                // Adjust for WITA (UTC+8)
                let hours = now.getHours();
                let minutes = now.getMinutes();
                let seconds = now.getSeconds();

                // Add leading zeros
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                const timeString = `${day}, ${hours}:${minutes}:${seconds} WITA`;
                document.getElementById('clock').textContent = timeString;
            }

            // Update clock immediately and then every second
            updateClock();
            setInterval(updateClock, 1000);
        </script>
    </body>
</html>
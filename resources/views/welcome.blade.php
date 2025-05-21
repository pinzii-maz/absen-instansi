<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sekretariat Daerah Provinsi Kalimantan Timur</title>
        
        <!-- DaisyUI dan Tailwind -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    
    <body class="antialiased">
        <!-- Navbar -->
        <div class="navbar bg-base-100 shadow-sm px-8 fixed top-0 z-50">
            <!-- Bagian Kiri -->
            <div class="navbar-start">
                <div class="flex items-center gap-2">
                    <img 
                        src="{{ asset('images/kaltim.png') }}" 
                        alt="Logo SETDA Kaltim" 
                        class="h-12 w-auto"
                    >
                    <div class="flex flex-col">
                        <h1 class="font-bold text-lg">Biro Administrasi Pimpinan</h1>
                        <p class="text-sm">Provinsi Kalimantan Timur</p>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan -->
            <div class="navbar-end gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-ghost">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="min-h-screen bg-gray-100 pt-20"> <!-- Padding top untuk navbar fixed -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Konten halaman -->
            </div>
        </div>
    </body>
</html>
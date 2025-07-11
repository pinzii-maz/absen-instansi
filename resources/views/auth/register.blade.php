<x-guest-layout>
    <!-- Add required styles -->
    <style>
        :root {
            --bg-light: #FFF5F6;
            --bg-dark: #111827;
            --text-light: #1a1a1a;
            --text-dark: #f3f4f6;
            --card-dark: #1f2937;
            --accent-dark: #60a5fa;
        }

        .auth-container {
            background-color: var(--bg-light);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .dark .auth-container {
            background-color: var(--bg-dark);
            background: linear-gradient(to bottom right, var(--bg-dark), #1a237e);
        }

        .auth-container::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, rgba(13, 17, 23, 0) 50%),
                radial-gradient(circle at 70% 30%, rgba(29, 78, 216, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 30% 70%, rgba(30, 64, 175, 0.1) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }

        .dark .auth-container::before {
            background: radial-gradient(circle, rgba(96, 165, 250, 0.2) 0%, rgba(13, 17, 23, 0) 50%),
                radial-gradient(circle at 70% 30%, rgba(96, 165, 250, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 30% 70%, rgba(96, 165, 250, 0.2) 0%, transparent 50%);
        }

        .form-input,
        .form-select {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(37, 99, 235, 0.2) !important;
            color: var(--text-light) !important;
        }

        .dark .form-input,
        .dark .form-select {
            background: rgba(31, 41, 55, 0.9) !important;
            border: 1px solid rgba(96, 165, 250, 0.2) !important;
            color: var(--text-dark) !important;
        }

        .dark .form-input::placeholder,
        .dark .form-select {
            color: rgba(156, 163, 175, 0.6);
        }

        .register-title {
            background: linear-gradient(45deg, #1a365d, #2563eb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .dark .register-title {
            background: linear-gradient(45deg, #60a5fa, #93c5fd);
            -webkit-background-clip: text;
            background-clip: text;
        }

        .auth-button {
            background: linear-gradient(45deg, #2563eb, #1e40af) !important;
            transition: all 0.3s ease !important;
            position: relative;
            overflow: hidden;
            border: none !important;
            padding: 0.75rem 2rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            font-size: 0.875rem;
            color: white !important;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translate(0, 0px) rotate(0deg);
            }

            25% {
                transform: translate(5px, 10px) rotate(1deg);
            }

            50% {
                transform: translate(0, 15px) rotate(0deg);
            }

            75% {
                transform: translate(-5px, 10px) rotate(-1deg);
            }

            100% {
                transform: translate(0, 0px) rotate(0deg);
            }
        }

        .section-fade {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(10px);
        }

        .section-fade.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Form container and layout */
        .auth-form {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-width: 42rem;
            margin: 0 auto;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .dark .auth-form {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(96, 165, 250, 0.1);
        }

        /* Custom select styling */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .form-select option {
            background-color: #ffffff;
            color: #1a365d;
            padding: 0.5rem;
        }

        /* Enhance form groups */
        .space-y-2 {
            margin-bottom: 1.5rem;
        }

        .space-y-2:last-child {
            margin-bottom: 0;
        }

        /* Label enhancements */
        .text-gray-300 {
            color: #1a365d !important;
            font-weight: 500;
            letter-spacing: 0.025em;
        }

        .dark .text-gray-300 {
            color: #d1d5db !important;
        }

        /* Link hover effects */
        .hover-link {
            color: #2563eb;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .hover-link:hover {
            color: #1e40af;
            text-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
        }

        .dark .hover-link:hover {
            color: var(--accent-dark);
        }

        /* Enhanced responsive design */
        @media (max-width: 640px) {
            .register-title {
                font-size: 2rem;
            }

            .auth-form {
                padding: 1.5rem !important;
                margin: 1rem;
            }
        }

        @media (max-width: 480px) {
            .register-title {
                font-size: 1.75rem;
            }

            .auth-form {
                padding: 1rem !important;
                margin: 0.5rem;
            }
        }

        /* Particle effect */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: rgba(59, 130, 246, 0.5);
            border-radius: 50%;
        }

        .dark .text-gray-400 {
            color: #9ca3af;
        }

        .dark .text-gray-500 {
            color: #6b7280;
        }

        .dark .text-blue-400 {
            color: var(--accent-dark);
        }

        .dark .text-blue-400:hover {
            color: #93c5fd;
        }
    </style>

    <div class="auth-container">
        <!-- Particle container -->
        <div class="particles" id="particles"></div>

        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="w-full max-w-xl" data-aos="fade-up">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/kaltim.png') }}" alt="Logo"
                        class="mx-auto h-24 w-auto mb-4 floating">
                    <h2 class="text-4xl font-bold register-title mb-2">Register</h2>
                    <p class="text-gray-400 text-lg">Buat akun baru</p>
                </div>

                <form method="POST" action="{{ route('register') }}"
                    class=" grid grid-cols-1 md:grid-cols-2 gap-6 auto-rows-min">
                    @csrf

                    <div class="space-y-2">
                        <x-input-label for="divisi_id" :value="__('Divisi')" class="text-gray-300 text-lg" />
                        <select id="divisi_id" name="divisi_id" class="block w-full form-select rounded-lg text-lg py-3"
                            required>
                            <option value="">Pilih Divisi</option>
                            @foreach ($divisi as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('divisi_id')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="role" :value="__('Jabatan')" class="text-gray-300 text-lg" />
                        <select id="role" name="role" class="block w-full form-select rounded-lg text-lg py-3"
                            required>
                            <option value="">Pilih Jabatan</option>
                            <option value="kepala_biro">Kepala Biro</option>
                            <option value="kepala_bagian_perencanaan_dan_kepegawaian">Kepala Bagian Perencanaan dan
                                Kepegawaian</option>
                            <option value="kepala_bagian_protokol">Kepala Bagian Protokol</option>
                            <option value="kepala_bagian_materi_dan_komunikasi_pimpinan">Kepala Bagian Materi dan
                                Komunikasi Pimpinan</option>
                            <option value="kepala_sub_bagian_tata_usaha">Kepala Sub Bagian Tata Usaha</option>
                            <option value="pelaksana">Jabatan Pelaksana</option>
                            <option value="jabatan fungsional">Jabatan Fungsional</option>
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-300 text-lg" />
                        <x-text-input id="name" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow"
                            type="text" name="name" :value="old('name')" required
                            placeholder="Masukkan nama lengkap" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="nip" :value="__('NIP')" class="text-gray-300 text-lg" />
                        <x-text-input id="nip" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow"
                            type="text" name="nip" :value="old('nip')" placeholder="Masukkan NIP (opsional)" />
                        <p class="mt-0 text-gray-400 text-sm italic">Jika anda memiliki NIP tolong di isi, jika tidak
                            ada anda bisa lewati</p>
                        <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                    </div>

                    <div class="space-y-2 mt-0">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-300 text-lg" />
                        <x-text-input id="email" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow"
                            type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-300 text-lg" />
                        <x-text-input id="password" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow"
                            type="password" name="password" required placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-300 text-lg" />
                        <x-text-input id="password_confirmation"
                            class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="password"
                            name="password_confirmation" required placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex justify-center pt-4 md:col-span-2">
                        <button type="submit"
                            class="w-full md:w-1/2 auth-button text-white py-4 rounded-lg font-semibold text-lg transition">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        {{ __('Sudah punya akun?') }}
                        <a href="{{ route('login') }}"
                            class="text-blue-400 hover:text-blue-300 hover:underline transition-colors font-medium">
                            {{ __('Login disini') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
            });

            // Particle effect
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const numberOfParticles = 50;

                for (let i = 0; i < numberOfParticles; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';

                    // Random position
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';

                    // Random size
                    const size = Math.random() * 3;
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';

                    // Random opacity
                    particle.style.opacity = Math.random() * 0.5 + 0.2;

                    // Animation
                    particle.style.animation = `floating ${Math.random() * 3 + 2}s ease-in-out infinite`;
                    particle.style.animationDelay = `${Math.random() * 2}s`;

                    particlesContainer.appendChild(particle);
                }
            }

            // Create particles
            createParticles();

            const roleSelect = document.getElementById('role');
            const pelaksanaFields = document.getElementById('pelaksanaFields');

            roleSelect.addEventListener('change', function() {
                if (this.value === 'pelaksana') {
                    pelaksanaFields.classList.remove('hidden');
                    setTimeout(() => {
                        pelaksanaFields.style.opacity = '1';
                    }, 50);
                    // Make fields required when visible
                    document.getElementById('unit_kerja').required = true;
                    document.getElementById('jabatan_fungsional').required = true;
                } else {
                    pelaksanaFields.style.opacity = '0';
                    setTimeout(() => {
                        pelaksanaFields.classList.add('hidden');
                    }, 300);
                    // Remove required when hidden
                    document.getElementById('unit_kerja').required = false;
                    document.getElementById('jabatan_fungsional').required = false;
                }
            });

            // Add hover effect to form inputs
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.classList.add('glow');
                });
                input.addEventListener('blur', () => {
                    input.classList.remove('glow');
                });
            });

            // Initialize theme from localStorage
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.body.classList.remove('light', 'dark');
            document.body.classList.add(savedTheme);

            // Listen for theme changes
            window.addEventListener('themeChanged', function(e) {
                const newTheme = e.detail;
                document.documentElement.setAttribute('data-theme', newTheme);
                document.body.classList.remove('light', 'dark');
                document.body.classList.add(newTheme);
            });
        });
    </script>
</x-guest-layout>

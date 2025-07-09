<x-guest-layout>
    <style>
        .auth-container {
            background-color: #f8fafc;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, rgba(13, 17, 23, 0) 50%),
                radial-gradient(circle at 70% 30%, rgba(29, 78, 216, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 30% 70%, rgba(30, 64, 175, 0.08) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg) scale(1);
            }

            50% {
                transform: rotate(180deg) scale(1.1);
            }

            100% {
                transform: rotate(360deg) scale(1);
            }
        }

        .form-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            max-width: 32rem;
            margin: 0 auto;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        .form-input {
            background: rgba(249, 250, 251, 0.9) !important;
            border: 1px solid rgba(37, 99, 235, 0.2) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: #1a202c !important;
            border-radius: 0.75rem;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.95) !important;
            border-color: rgba(37, 99, 235, 0.5) !important;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.2) !important;
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: rgba(107, 114, 128, 0.8);
        }

        .form-title {
            background: linear-gradient(45deg, #1e3a8a, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            text-shadow: 0 0 30px rgba(37, 99, 235, 0.2);
        }

        .auth-button {
            background: linear-gradient(45deg, #2563eb, #1e40af) !important;
            transition: all 0.3s ease !important;
            position: relative;
            overflow: hidden;
            border: none !important;
            padding: 0.85rem 2rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            font-size: 0.875rem;
            color: white !important;
            border-radius: 9999px;
            width: 100%;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, 15px);
            }

            100% {
                transform: translate(0, 0px);
            }
        }

        .text-description {
            color: #4a5568;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .input-label {
            color: #2d3748 !important;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        @media (max-width: 640px) {
            .form-title {
                font-size: 2rem;
            }

            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>

    <div class="auth-container">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="w-full max-w-md" data-aos="fade-up">
                <div class="form-container">

                    <div class="text-center mb-8">
                        <img src="{{ asset('images/kaltim.png') }}" alt="Logo"
                            class="mx-auto h-24 w-auto mb-6 floating">
                        <h2 class="form-title mb-3">Reset Password</h2>
                        <p class="text-description">
                            Buat password baru Anda. Pastikan kuat dan mudah diingat.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="space-y-2">
                            <x-input-label for="email" value="Email" class="input-label" />
                            <x-text-input id="email" class="block w-full form-input py-3 px-4 bg-gray-200/50"
                                type="email" name="email" :value="old('email', $request->email)" required readonly
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="password" value="Password Baru" class="input-label" />
                            <div class="relative">
                                <x-text-input id="password" class="block w-full form-input py-3 px-4 pr-12"
                                    type="password" name="password" required autocomplete="new-password"
                                    placeholder="Masukkan password baru" />
                                <button type="button" onclick="togglePasswordVisibility('password', 'icon-password')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-blue-600 focus:outline-none">
                                    <svg id="icon-password" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru"
                                class="input-label" />
                            <div class="relative">
                                <x-text-input id="password_confirmation" class="block w-full form-input py-3 px-4 pr-12"
                                    type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Ketik ulang password baru" />
                                <button type="button"
                                    onclick="togglePasswordVisibility('password_confirmation', 'icon-password-confirm')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-blue-600 focus:outline-none">
                                    <svg id="icon-password-confirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="auth-button">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        // Fungsi ini sekarang berada di lingkup global, sehingga bisa diakses oleh 'onclick'
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';

            // Ganti ikon mata terbuka/tertutup
            icon.innerHTML = isPassword ?
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 .847 0 1.67.127 2.456.368M18.428 5.628A9.957 9.957 0 0121.542 12c-1.274 4.057-5.064 7-9.542 7a9.954 9.954 0 01-1.428-.128M4.929 4.929L19.071 19.071" />` :
                `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }

        // Inisialisasi AOS dijalankan setelah halaman siap
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
            });
        });
    </script>
</x-guest-layout>

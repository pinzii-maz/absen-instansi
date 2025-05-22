<x-guest-layout>
    <!-- Add required styles -->
    <style>
        .auth-container {
            background-color: #FFF5F6;
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
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, rgba(13, 17, 23, 0) 50%),
                        radial-gradient(circle at 70% 30%, rgba(29, 78, 216, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 30% 70%, rgba(30, 64, 175, 0.1) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
            z-index: 0;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            max-width: 32rem;
            margin: 0 auto;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(37, 99, 235, 0.2) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: #1a365d !important;
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
        }
        
        .form-input:focus {
            background: rgba(255, 255, 255, 0.95) !important;
            border-color: rgba(37, 99, 235, 0.5) !important;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.2) !important;
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: rgba(55, 65, 81, 0.6);
        }

        .forgot-title {
            background: linear-gradient(45deg, #1a365d, #2563eb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 2.5rem;
            letter-spacing: -0.02em;
            text-shadow: 0 0 30px rgba(37, 99, 235, 0.3);
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
            border-radius: 9999px;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translate(0, 0px) rotate(0deg); }
            25% { transform: translate(5px, 10px) rotate(1deg); }
            50% { transform: translate(0, 15px) rotate(0deg); }
            75% { transform: translate(-5px, 10px) rotate(-1deg); }
            100% { transform: translate(0, 0px) rotate(0deg); }
        }

        .text-description {
            color: #1a365d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Label enhancements */
        .input-label {
            color: #1a365d !important;
            font-weight: 500;
            letter-spacing: 0.025em;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .hover-link {
            color: #2563eb;
            transition: all 0.3s ease;
            font-weight: 500;
            text-decoration: none;
        }

        .hover-link:hover {
            color: #1e40af;
            text-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
        }

        /* Enhanced responsive design */
        @media (max-width: 640px) {
            .forgot-title {
                font-size: 2rem;
            }
            
            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .auth-button {
                padding: 0.6rem 1.5rem;
                width: 100%;
            }

            .text-description {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .forgot-title {
                font-size: 1.75rem;
            }
            
            .form-container {
                margin: 0.5rem;
                padding: 1rem;
            }
        }
    </style>

    <div class="auth-container">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="w-full max-w-md" data-aos="fade-up">
                <div class="form-container">
                    <!-- Logo and Title -->
                    <div class="text-center mb-8">
                        <img src="{{ asset('images/kaltim.png') }}" alt="Logo" class="mx-auto h-24 w-auto mb-6 floating">
                        <h2 class="forgot-title mb-3">Lupa Password?</h2>
                        <p class="text-description">
                            {{ __('Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan reset password yang memungkinkan Anda memilih yang baru.') }}
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <x-input-label for="email" :value="__('Email')" class="input-label" />
                            <x-text-input id="email" class="block w-full form-input py-3 px-4" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-center mt-6">
                            <button type="submit" class="auth-button">
                                {{ __('Kirim Link Reset Password') }}
                            </button>
                        </div>

                        <!-- Back to Login Link -->
                        <div class="text-center mt-6">
                            <a href="{{ route('login') }}" class="hover-link">
                                {{ __('Kembali ke halaman login') }}
                            </a>
                        </div>
                    </form>
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
        });
    </script>
</x-guest-layout>

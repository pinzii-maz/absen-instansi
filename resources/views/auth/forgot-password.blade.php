<x-guest-layout>
 
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

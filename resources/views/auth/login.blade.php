<x-guest-layout>
    <!-- Add required styles -->
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    @endpush
    <div class="auth-container">
        <!-- Background Pattern -->
        <div class="bg-pattern"></div>

        <!-- Particle container -->
        <div class="particles" id="particles"></div>

        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="w-full max-w-md" data-aos="fade-up">
                <div>
                    <!-- Logo and Title -->
                    <div class="text-center mb-8">
                        <img src="{{ asset('images/kaltim.png') }}" alt="Logo"
                            class="mx-auto h-24 w-auto mb-6 floating">
                        <h2 class="text-4xl font-bold login-title mb-3">Login</h2>
                        <p class="text-gray-900 text-lg">Selamat datang kembali!</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div class="input-group">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <x-input-label for="email" :value="__('Email')" :value="__('Email & Nama')"
                                class="text-gray-300 text-lg mb-2" />
                            <x-text-input id="login" class="block w-full form-input rounded-lg text-lg py-3"
                                type="text" name="login" :value="old('login')" required autocomplete="username"
                                placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="input-group">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-300 text-lg mb-2" />
                            <x-text-input id="password" class="block w-full form-input rounded-lg text-lg py-3"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="custom-checkbox" name="remember">
                                <span class="ms-2 text-gray-900">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="hover-link" href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full auth-button text-white py-4 rounded-lg text-lg transition">
                                {{ __('Log in') }}
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center mt-6">
                            <p class="text-gray-400">
                                {{ __('Belum punya akun?') }}
                                <a href="{{ route('register') }}" class="hover-link ms-1">
                                    {{ __('Register disini') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</x-guest-layout>

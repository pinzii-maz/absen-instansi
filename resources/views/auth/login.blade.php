<x-guest-layout>
    <!-- Add required styles -->
    <style>
        .auth-container {
            background-color: #FFF5F6;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Enhanced animated background patterns */
        .bg-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(37, 99, 235, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(29, 78, 216, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 50% 80%, rgba(30, 64, 175, 0.1) 0%, transparent 25%);
            animation: patternMove 20s ease-in-out infinite alternate;
            z-index: 0;
        }

        .decorative-pattern {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            z-index: 0;
            opacity: 0.4;
        }

        @keyframes patternMove {
            0% { transform: translateY(0) scale(1) rotate(0deg); }
            50% { transform: translateY(-25px) scale(1.05) rotate(1deg); }
            100% { transform: translateY(-50px) scale(1.1) rotate(2deg); }
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

        .login-title {
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

        .hover-link {
            color: #2563eb;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .hover-link:hover {
            color: #1e40af;
            text-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
        }

        /* Custom checkbox styling */
        .custom-checkbox {
            appearance: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid rgba(37, 99, 235, 0.4);
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .custom-checkbox:checked {
            background: #2563eb;
            border-color: #2563eb;
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 0.8rem;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .custom-checkbox:hover {
            border-color: #2563eb;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.2);
        }

        /* Input group styling */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(55, 65, 81, 0.6);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .input-group:focus-within .input-icon {
            color: #2563eb;
            transform: translateY(-50%) scale(1.1);
        }

        .input-group input {
            padding-left: 2.75rem !important;
        }

        /* Enhanced responsive design */
        @media (max-width: 640px) {
            .login-title {
                font-size: 2rem;
            }
            
            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .auth-button {
                padding: 0.6rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .login-title {
                font-size: 1.75rem;
            }
            
            .form-container {
                margin: 0.5rem;
                padding: 1rem;
            }
        }
    </style>

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
                        <img src="{{ asset('images/kaltim.png') }}" alt="Logo" class="mx-auto h-24 w-auto mb-6 floating">
                        <h2 class="text-4xl font-bold login-title mb-3">Login</h2>
                        <p class="text-gray-400 text-lg">Selamat datang kembali!</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div class="input-group">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <x-input-label for="email" :value="__('Email')" class="text-gray-300 text-lg mb-2" />
                            <x-text-input id="email" class="block w-full form-input rounded-lg text-lg py-3" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="input-group">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <x-input-label for="password" :value="__('Password')" class="text-gray-300 text-lg mb-2" />
                            <x-text-input id="password" class="block w-full form-input rounded-lg text-lg py-3" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="custom-checkbox" name="remember">
                                <span class="ms-2 text-gray-300">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="hover-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full auth-button text-white py-4 rounded-lg text-lg transition">
                                {{ __('Log in') }}
                            </button>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center mt-6">
                            <p class="text-gray-400">
                                {{ __("Don't have an account?") }}
                                <a href="{{ route('register') }}" class="hover-link ms-1">
                                    {{ __('Register here') }}
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                easing: 'ease-out-cubic'
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
                    const animationDuration = Math.random() * 3 + 2;
                    const animationDelay = Math.random() * 2;
                    particle.style.animation = `floating ${animationDuration}s ease-in-out infinite`;
                    particle.style.animationDelay = `${animationDelay}s`;
                    
                    particlesContainer.appendChild(particle);
                }
            }

            createParticles();

            // Add input focus effects
            const inputGroups = document.querySelectorAll('.input-group');
            inputGroups.forEach(group => {
                const input = group.querySelector('input');
                const icon = group.querySelector('.input-icon');

                input.addEventListener('focus', () => {
                    icon.style.color = '#3b82f6';
                    group.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', () => {
                    icon.style.color = 'rgba(255, 255, 255, 0.4)';
                    group.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</x-guest-layout>

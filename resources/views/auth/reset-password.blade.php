<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <!-- Ilustrasi SVG inline -->
        <div class="mb-6">
            <svg width="80" height="80" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" fill="#e0e7ff" />
                <path d="M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#6366f1" />
                <rect x="11" y="14" width="2" height="4" rx="1" fill="#6366f1" />
            </svg>
        </div>

        <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-2xl border border-gray-200">
            <h2 class="mb-8 text-3xl font-extrabold text-center text-gray-800 tracking-tight">Reset Password</h2>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 mb-1" />
                    <x-text-input id="email"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                        type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"
                        placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-5 relative">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700 mb-1" />
                    <x-text-input id="password"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition pr-12"
                        type="password" name="password" required autocomplete="new-password"
                        placeholder="New password" />
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute right-3 top-9 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 focus:outline-none">
                        <!-- Eye SVG -->
                        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-8 relative">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 mb-1" />
                    <x-text-input id="password_confirmation"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition pr-12"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Confirm new password" />
                    <button type="button" onclick="togglePassword('password_confirmation')"
                        class="absolute right-3 top-9 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 focus:outline-none">
                        <!-- Eye SVG -->
                        <svg id="icon-password-confirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit"
                    class="w-full py-3 px-4 bg-indigo-700 text-white font-bold rounded-lg shadow hover:bg-indigo-800 transition text-lg tracking-wide">
                    {{ __('RESET PASSWORD') }}
                </button>
            </form>
        </div>
    </div>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>

<x-guest-layout>
    <div class="auth-container">
        <!-- Particle container -->
        <div class="particles" id="particles"></div>

        <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="w-full max-w-xl" data-aos="fade-up">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/kaltim.png') }}" alt="Logo" class="mx-auto h-24 w-auto mb-4 floating">
                    <h2 class="text-4xl font-bold register-title mb-2">Register</h2>
                    <p class="text-gray-400 text-lg">Buat akun baru</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class=" grid grid-cols-1 md:grid-cols-2 gap-6 auto-rows-min">
                    @csrf

                    <!-- Jabatan (Left Column, Row 1) -->
                    <div class="space-y-2">
                        <x-input-label for="role" :value="__('Jabatan')" class="text-gray-800 text-lg" />
                        <select id="role" name="role" class="block w-full form-select rounded-lg text-lg py-3" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="kepala_biro">Kepala Biro</option>
                            <option value="kepala_bagian_perencanaan_dan_kepegawaian">Kepala Bagian Perencanaan dan Kepegawaian</option>
                            <option value="kepala_bagian_protokol">Kepala Bagian Protokol</option>
                            <option value="kepala_bagian_materi_dan_komunikasi_pimpinan">Kepala Bagian Materi dan Komunikasi Pimpinan</option>
                            <option value="kepala_sub_bagian_tata_usaha">Kepala Sub Bagian Tata Usaha</option>
                            <option value="analisi_kebijakan_ahli_muda">Analisi Kebijakan Ahli Muda</option>
                            <option value="pranata_hubungan_masyarakat_ahli_muda">Pranata Hubungan Masyarakat Ahli Muda</option>
                            <option value="pelaksana">Pelaksana</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Nama Lengkap (Right Column, Row 1) -->
                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-900 text-lg" />
                        <x-text-input id="name" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="text" name="name" :value="old('name')" required placeholder="Masukkan nama lengkap" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- NIP (Left Column, Row 2) -->
                    <div class="space-y-2">
                        <x-input-label for="nip" :value="__('NIP')" class="text-gray-900 text-lg" />
                        <x-text-input id="nip" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="text" name="nip" :value="old('nip')" placeholder="Masukkan NIP (opsional)" />
                        <p class="mt-0 text-red-500 text-sm italic">Jika anda memiliki NIP tolong di isi, jika tidak ada anda bisa lewati</p>
                        <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                    </div>

                    <!-- Password (Right Column, Row 2) -->
                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-900 text-lg" />
                        <x-text-input id="password" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="password" name="password" required placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Email Address (Left Column, Row 3) -->
                    <div class="space-y-2 mt-0">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-900 text-lg" />
                        <x-text-input id="email" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password (Right Column, Row 3) -->
                    <div class="space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-900 text-lg" />
                        <x-text-input id="password_confirmation" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="password" name="password_confirmation" required placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Dynamic Fields for Pelaksana (Spans two columns) -->
                    <div id="pelaksanaFields" class="hidden space-y-6 section-fade md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-input-label for="unit_kerja" :value="__('Unit Kerja')" class="text-gray-900 text-lg" />
                                <x-text-input id="unit_kerja" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="text" name="unit_kerja" :value="old('unit_kerja')" placeholder="Masukkan unit kerja" />
                                <x-input-error :messages="$errors->get('unit_kerja')" class="mt-2" />
                            </div>
                            <div class="space-y-2">
                                <x-input-label for="jabatan_fungsional" :value="__('Jabatan Fungsional')" class="text-gray-900 text-lg" />
                                <x-text-input id="jabatan_fungsional" class="block w-full form-input rounded-lg text-lg py-3 px-4 glow" type="text" name="jabatan_fungsional" :value="old('jabatan_fungsional')" placeholder="Masukkan jabatan fungsional" />
                                <x-input-error :messages="$errors->get('jabatan_fungsional')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Register Button (Spans two columns and centered) -->
                    <div class="flex justify-center pt-4 md:col-span-2">
                        <button type="submit" class="w-full md:w-1/2 auth-button text-white py-4 rounded-lg font-semibold text-lg transition">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        {{ __('Sudah punya akun?') }}
                        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 hover:underline transition-colors font-medium">
                            {{ __('Login disini') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</x-guest-layout>
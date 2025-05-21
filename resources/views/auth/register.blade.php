<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('Jabatan')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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

        <!-- NIP -->
        <div>
            <x-input-label for="nip" :value="__('NIP')" />
            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" autofocus />
            <p class="mt-1 text-sm text-gray-500">Jika anda memiliki NIP tolong di isi, jika tidak ada anda bisa lewati</p>
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Dynamic Fields for Pelaksana -->
        <div id="pelaksanaFields" class="hidden space-y-4">
            <div>
                <x-input-label for="unit_kerja" :value="__('Unit Kerja')" />
                <x-text-input id="unit_kerja" class="block mt-1 w-full" type="text" name="unit_kerja" :value="old('unit_kerja')" />
                <x-input-error :messages="$errors->get('unit_kerja')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="jabatan_fungsional" :value="__('Jabatan Fungsional')" />
                <x-text-input id="jabatan_fungsional" class="block mt-1 w-full" type="text" name="jabatan_fungsional" :value="old('jabatan_fungsional')" />
                <x-input-error :messages="$errors->get('jabatan_fungsional')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const pelaksanaFields = document.getElementById('pelaksanaFields');

            roleSelect.addEventListener('change', function() {
                if (this.value === 'pelaksana') {
                    pelaksanaFields.classList.remove('hidden');
                    // Make fields required when visible
                    document.getElementById('unit_kerja').required = true;
                    document.getElementById('jabatan_fungsional').required = true;
                } else {
                    pelaksanaFields.classList.add('hidden');
                    // Remove required when hidden
                    document.getElementById('unit_kerja').required = false;
                    document.getElementById('jabatan_fungsional').required = false;
                }
            });
        });
    </script>
    @endpush
</x-guest-layout>

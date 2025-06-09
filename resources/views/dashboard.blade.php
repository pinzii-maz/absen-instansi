<x-app-layout>
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen z-10 py-6 sm:py-12 px-4 sm:px-6 lg:px-8"
        style="background: linear-gradient(135deg, #f6f8fc 0%, #e9edf5 100%);">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome and Attendance Section -->
            <div
                class="bg-white rounded-xl shadow-xl mb-6 sm:mb-8 transform transition-all duration-300 hover:shadow-2xl">
                <div class="p-4 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 items-center">
                        <!-- Left side - Illustration -->
                        <div class="flex justify-center">
                            <img src="images/icon_Dashboard.png" alt="Attendance Illustration"
                                class="max-w-full h-auto max-h-48 sm:max-h-64 floating">
                        </div>

                        <!-- Right side - Welcome Message and Attendance Status -->
                        <div class="space-y-4 sm:space-y-6">
                            <div class="welcome-message" data-aos="fade-up">
                                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
                                    @if (!session('has_attended_today'))
                                        Selamat Datang, {{ auth()->user()->name }}!
                                    @else
                                        Selamat Bertugas, {{ auth()->user()->name }}!
                                    @endif
                                </h1>
                                <p class="text-base sm:text-lg text-gray-600">
                                    @if (!session('has_attended_today'))
                                        Jangan lupa absen hari ini ya!
                                    @else
                                        Semoga Harimu Menyenangkan
                                    @endif
                                </p>
                            </div>

                            <!-- Statistics Cards -->
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-6 sm:mt-8" data-aos="fade-up"
                                data-aos-delay="200">
                                <div class="stats-card p-3 sm:p-4 rounded-lg shadow-lg card-hover">
                                    <div class="text-2xl sm:text-3xl font-bold text-blue-600">
                                        {{ $totalAttendance ?? 0 }}</div>
                                    <div class="text-xs sm:text-sm text-gray-600">Total Kehadiran Bulan Ini</div>
                                </div>
                                <div class="stats-card p-3 sm:p-4 rounded-lg shadow-lg card-hover">
                                    <div class="text-2xl sm:text-3xl font-bold text-blue-600">
                                        {{ $onTimePercentage ?? 0 }}%</div>
                                    <div class="text-xs sm:text-sm text-gray-600">Tepat Waktu</div>
                                </div>
                            </div>

                            <!-- Attendance Actions -->
                            <div class="space-y-3 sm:space-y-4" data-aos="fade-up" data-aos-delay="100">
                                <div class="flex flex-wrap gap-2 sm:gap-4">
                                    <button id="btnAbsenMasuk" onclick="checkWifiAndRecord('masuk')"
                                        class="flex-1 sm:flex-none flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Absen Masuk
                                    </button>

                                    <button id="btnAbsenPulang" onclick="checkWifiAndRecord('pulang')"
                                        class="flex-1 sm:flex-none flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/30 disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Absen Pulang
                                    </button>

                                    <button onclick="showIzinModal()"
                                        class="flex-1 sm:flex-none flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all duration-300 shadow-lg hover:shadow-gray-500/30 text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        Ajukan Izin
                                    </button>
                                </div>

                                <div id="wifiStatus"
                                    class="mt-3 sm:mt-4 bg-white rounded-lg p-3 sm:p-4 shadow-md border border-gray-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-blue-500 animate-spin"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span class="text-sm sm:text-base text-gray-700">Memeriksa koneksi
                                            WiFi...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Information Section -->
            <div
                class="bg-white rounded-xl shadow-xl transform transition-all duration-300 hover:shadow-2xl mb-6 sm:mb-8">
                <div class="p-4 sm:p-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 sm:mb-8 flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-gray-800" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pegawai
                    </h3>

                    <div class="grid grid-cols-4 md:grid-cols-2 gap-4 sm:gap-8">
                        <!-- Basic Information -->
                        <div class="space-y-4 sm:space-y-6">
                            <div
                                class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Nama Lengkap</h4>
                                <p class="text-base sm:text-lg font-semibold text-gray-800">{{ auth()->user()->name }}
                                </p>
                            </div>
                            <div
                                class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Email</h4>
                                <p class="text-base sm:text-lg font-semibold text-gray-800">{{ auth()->user()->email }}
                                </p>
                            </div>
                            <div
                                class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">NIP</h4>
                                <p class="text-base sm:text-lg font-semibold text-gray-800">{{ auth()->user()->nip }}
                                </p>
                            </div>
                        </div>

                        <!-- Position Information -->
                        <div class="space-y-4 sm:space-y-6">
                            <div
                                class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Jabatan</h4>
                                <p class="text-base sm:text-lg font-semibold text-gray-800">
                                    {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</p>
                            </div>

                            @if (auth()->user()->role === 'pelaksana')
                                <div
                                    class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                    <h4 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Unit Kerja</h4>
                                    <p class="text-base sm:text-lg font-semibold text-gray-800">
                                        {{ auth()->user()->unit_kerja }}</p>
                                </div>
                                <div
                                    class="bg-gray-50 rounded-lg p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                    <h4 class="text-xs sm:text-sm font-medium text-gray-500 mb-1">Jabatan Fungsional
                                    </h4>
                                    <p class="text-base sm:text-lg font-semibold text-gray-800">
                                        {{ auth()->user()->jabatan_fungsional }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Request Status Section -->
            <div class="bg-white rounded-xl shadow-xl transform transition-all duration-300 hover:shadow-2xl">
                <div class="p-4 sm:p-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 sm:mb-8 flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-gray-800" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Status Pengajuan Izin
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 sm:px-6 py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Izin</th>
                                    <th
                                        class="px-4 sm:px-6 py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-4 sm:px-6 py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-4 sm:px-6 py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                        Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Pastikan nama variabelnya '$leaveRequests' --}}
                                @forelse($leaveRequests as $request)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->jenisKehadiran->name }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->tanggal_masuk->format('d M Y') }} -
                                            {{ $request->tanggal_selesai_izin ? $request->tanggal_selesai_izin->format('d M Y') : '' }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                            @php
                                                // PERBAIKI: Gunakan 'status_izin' dan 'menunggu'
                                                $statusClass =
                                                    [
                                                        'menunggu' => 'bg-yellow-100 text-yellow-800', // Ganti 'proses' menjadi 'menunggu'
                                                        'disetujui' => 'bg-green-100 text-green-800',
                                                        'ditolak' => 'bg-red-100 text-red-800',
                                                    ][$request->status_izin] ?? 'bg-gray-100 text-gray-800'; // Ganti $request->status menjadi $request->status_izin
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($request->status_izin) }} {{-- Ganti $request->status menjadi $request->status_izin --}}
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900 break-words">
                                            {{ $request->keterangan_izin }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada pengajuan izin
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Request Modal -->
    <div id="izinModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-4 sm:p-8 border w-[95%] sm:w-[480px] shadow-2xl rounded-xl bg-white">
            <div class="absolute top-4 right-4">
                <button onclick="closeIzinModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mb-6 sm:mb-8">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">Ajukan Izin</h3>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Silakan lengkapi form berikut untuk mengajukan izin
                </p>
            </div>

            <form id="izinForm" class="space-y-4 sm:space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Izin</label>
                    <select name="jenis_izin"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-700 focus:border-blue-500 focus:ring-blue-500"
                        required>

                        <option value="" disabled selected>Pilih jenis izin</option>

                        {{-- Loop ini akan membuat option secara otomatis dari database --}}
                        @foreach ($jenisKehadiran as $jenis)
                            {{-- value akan menjadi 'S', 'I', 'C' (sesuai database), dan teksnya adalah nama lengkapnya --}}
                            <option value="{{ $jenis->code }}">{{ $jenis->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full rounded-lg border-gray-300 bg-white focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all text-sm sm:text-base text-gray-700"
                        placeholder="Tuliskan alasan izin Anda..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Surat Pendukung</label>
                    <div
                        class="mt-1 flex justify-center px-4 sm:px-6 pt-4 sm:pt-5 pb-4 sm:pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 sm:h-12 w-10 sm:w-12 text-gray-400" stroke="currentColor"
                                fill="none" viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="file-upload"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload file</span>
                                    <input id="file-upload" name="surat" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, DOC up to 10MB</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 sm:space-x-4 mt-6 sm:mt-8">
                    <button type="button" onclick="closeIzinModal()"
                        class="px-4 sm:px-6 py-2 sm:py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300 text-sm sm:text-base">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/30 text-sm sm:text-base">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Pastikan elemen-elemen ini ada di HTML Anda
        const btnAbsenMasuk = document.getElementById('btnAbsenMasuk');
        const btnAbsenPulang = document.getElementById('btnAbsenPulang');
        // Ganti 'wifiStatus' jika ID elemen Anda berbeda untuk menampilkan pesan IP/status
        const statusMessageContainer = document.getElementById('wifiStatus') || document.getElementById('ipStatusMessage');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Ambil status dari session PHP yang di-render ke JavaScript
        let hasAttendedToday = {{ session('has_attended_today') ? 'true' : 'false' }};
        let hasClockedOutToday = {{ session('has_clocked_out_today') ? 'true' : 'false' }};

        function updateButtonStates() {
            if (hasAttendedToday) {
                btnAbsenMasuk.disabled = true;
                btnAbsenMasuk.classList.add('opacity-50', 'cursor-not-allowed'); // atau class 'btn-disabled'

                if (hasClockedOutToday) {
                    btnAbsenPulang.disabled = true;
                    btnAbsenPulang.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    btnAbsenPulang.disabled = false;
                    btnAbsenPulang.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            } else {
                btnAbsenMasuk.disabled = false;
                btnAbsenMasuk.classList.remove('opacity-50', 'cursor-not-allowed');
                btnAbsenPulang.disabled = true;
                btnAbsenPulang.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateButtonStates();
            if (statusMessageContainer) {
                // Anda bisa menambahkan teks awal jika mau
                // statusMessageContainer.querySelector('span').textContent = "Siap untuk absen."; 
            }
        });

        async function checkWifiAndRecord(type) {
            const button = (type === 'masuk') ? btnAbsenMasuk : btnAbsenPulang;
            // Pastikan btnAbsenMasuk dan btnAbsenPulang sudah didefinisikan dan ditemukan
            if (!button) {
                console.error('Tombol absen tidak ditemukan untuk tipe:', type);
                return;
            }
            const originalButtonText = button.innerHTML;

            button.disabled = true;
            button.innerHTML =
                `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;

            if (statusMessageContainer && statusMessageContainer.querySelector('span')) {
                statusMessageContainer.querySelector('span').textContent = "Memvalidasi jaringan...";
            }

            let targetRouteName = '';
            if (type === 'masuk') {
                targetRouteName = "{{ route('kehadiran.masuk') }}"; // <-- Diubah ke nama route yang benar
            } else if (type === 'pulang') {
                targetRouteName = "{{ route('kehadiran.pulang') }}"; // <-- Diubah ke nama route yang benar
            } else {
                console.error('Tipe absensi tidak valid:', type);
                showNotification('Tipe absensi tidak valid.', 'error');
                button.disabled = false;
                button.innerHTML = originalButtonText;
                updateButtonStates(); // Pastikan fungsi ini ada dan dipanggil
                return;
            }

            try {
                const response = await fetch(targetRouteName, { // <-- Menggunakan variabel targetRouteName
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken, // Pastikan csrfToken sudah didefinisikan
                        'Accept': 'application/json',
                    },
                    // 'type' dalam body mungkin tidak lagi diperlukan karena sudah dibedakan oleh route
                    // Namun, tidak masalah jika tetap dikirim, controller bisa mengabaikannya.
                    body: JSON.stringify({
                        type: type
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showNotification(data.message, 'success');
                    if (statusMessageContainer && statusMessageContainer.querySelector('span')) {
                        statusMessageContainer.querySelector('span').textContent = data.message;
                    }

                    if (type === 'masuk') {
                        hasAttendedToday = true;
                        // Jika ada perubahan UI lain setelah absen masuk (misal pesan selamat datang)
                        // document.querySelector('.welcome-message h1').textContent = "Selamat Bertugas, {{ auth()->user()->name }}!";
                        // document.querySelector('.welcome-message p').textContent = "Semoga Harimu Menyenangkan";

                    } else if (type === 'pulang') {
                        hasClockedOutToday = true;
                    }
                    updateButtonStates(); // Pastikan fungsi ini ada dan dipanggil
                    // Pertimbangkan apakah perlu reload halaman atau cukup update UI
                    // location.reload(); 
                } else {
                    showNotification(data.message || 'Gagal melakukan absensi.', 'error');
                    if (statusMessageContainer && statusMessageContainer.querySelector('span')) {
                        statusMessageContainer.querySelector('span').textContent = data.message || 'Gagal, coba lagi.';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan koneksi.', 'error');
                if (statusMessageContainer && statusMessageContainer.querySelector('span')) {
                    statusMessageContainer.querySelector('span').textContent = "Kesalahan koneksi.";
                }
            } finally {
                button.innerHTML = originalButtonText;
                // Panggil updateButtonStates lagi untuk memastikan status tombol benar setelah proses
                // karena mungkin button.disabled di-set false lagi oleh updateButtonStates() jika kondisi terpenuhi
                updateButtonStates();
                // Jika updateButtonStates() tidak meng-cover semua kondisi, Anda mungkin perlu set button.disabled lagi di sini
                // if(! ( (type === 'masuk' && hasAttendedToday) || (type === 'pulang' && hasClockedOutToday) ) ){
                //    button.disabled = false; // Hanya aktifkan jika belum berhasil absen
                // }
            }
        }

        document.getElementById('izinForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;

            submitButton.disabled = true;
            submitButton.innerHTML =
                `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" ...></svg> Mengirim...`;

            const formData = new FormData(this);
            // Tambahkan kode jenis izin dari select ke FormData jika nama field di backend berbeda
            // Misalnya jika select name="jenis_izin" di HTML, tapi backend expect "kode_izin"
            // formData.append('kode_izin', this.querySelector('select[name="jenis_izin"]').value);

            try {
                const response = await fetch("{{ route('kehadiran.izin') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        // Content-Type akan diatur otomatis oleh FormData jika ada file
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showNotification(data.message, 'success');
                    closeIzinModal();
                    this.reset(); // Reset form

                    // Cek apakah izin mencakup hari ini
                    const tanggalMulai = new Date(formData.get('tanggal_mulai') + 'T00:00:00');
                    const tanggalSelesai = new Date(formData.get('tanggal_selesai') + 'T23:59:59');
                    const today = new Date();

                    if (today >= tanggalMulai && today <= tanggalSelesai) {
                        hasAttendedToday = true;
                        updateButtonStates();
                    }
                    // location.reload(); // Cara paling mudah, tapi kurang ideal
                } else {
                    showNotification(data.message || 'Gagal mengirim pengajuan izin.', 'error');
                }
            } catch (error) {
                console.error('Error submitting leave:', error);
                showNotification('Terjadi kesalahan koneksi saat mengirim izin.', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            }
        });

        // Fungsi showIzinModal, closeIzinModal, showNotification (dari kode Anda)
        // ... (letakkan di sini) ...
        function showIzinModal() {
            const modal = document.getElementById('izinModal');
            modal.classList.remove('hidden');
            // Jika menggunakan class untuk transisi:
            // setTimeout(() => modal.querySelector('.relative').classList.add('transform', 'translate-y-0', 'opacity-100'), 10);
        }

        function closeIzinModal() {
            const modal = document.getElementById('izinModal');
            // Jika menggunakan class untuk transisi:
            // modal.querySelector('.relative').classList.remove('transform', 'translate-y-0', 'opacity-100');
            // setTimeout(() => modal.classList.add('hidden'), 300);
            modal.classList.add('hidden');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('izinModal');
            if (event.target == modal) {
                closeIzinModal();
            }
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg transform transition-all duration-300 z-50 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0'; // Mulai fade out
                setTimeout(() => notification.remove(), 300); // Hapus setelah transisi
            }, 3000); // Tampilkan selama 3 detik
        }

        // Update file upload handling
        const fileUploadInput = document.getElementById('file-upload');
        const fileDropZone = fileUploadInput.closest('.border-dashed');

        if (fileUploadInput && fileDropZone) {
            // Handle file selection
            fileUploadInput.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : 'atau drag and drop';
                const fileDropText = this.closest('.flex.text-sm.text-gray-600').querySelector('p.pl-1');
                if (fileDropText) fileDropText.textContent = fileName;
            });

            // Handle drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                fileDropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                fileDropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                fileDropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                fileDropZone.classList.add('border-blue-500');
            }

            function unhighlight(e) {
                fileDropZone.classList.remove('border-blue-500');
            }

            fileDropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileUploadInput.files = files;

                const fileName = files[0] ? files[0].name : 'atau drag and drop';
                const fileDropText = fileUploadInput.closest('.flex.text-sm.text-gray-600').querySelector('p.pl-1');
                if (fileDropText) fileDropText.textContent = fileName;
            }
        }
    </script>
</x-app-layout>

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

                            <!-- Real-Time Clock and Notification Area -->
                            <div class="flex flex-col items-center mb-2">
                                <div id="realtimeClock"
                                    style="color:#1e40af;font-size:2.25rem;font-family:monospace;font-weight:bold;letter-spacing:0.1em;opacity:1;text-shadow:0 2px 8px #e0e7ef;">
                                </div>
                                <div id="absenNotification"
                                    style="font-size:1.1rem;font-weight:600;min-height:40px;padding:0.75rem 1.25rem;margin-top:0.25rem;margin-bottom:0.5rem;border-radius:0.75rem;display:flex;align-items:center;opacity:1;background:#f8fafc;color:#1e293b;border:1.5px solid #e5e7eb;transition:all .3s;">
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
                                    class="mt-3 sm:mt-4 bg-gray-50 rounded-lg p-3 sm:p-4 shadow-sm border border-gray-200 transition-all duration-300">
                                    <div class="flex items-center">
                                        {{-- Kita beri ID agar ikonnya bisa diganti --}}
                                        <div id="wifiIcon" class="w-5 h-5 mr-2">
                                            <svg class="animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </div>
                                        {{-- Kita beri ID agar teksnya bisa diganti --}}
                                        <span id="wifiText" class="text-sm sm:text-base text-gray-700">Memeriksa
                                            koneksi...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Information Section -->
            {{-- Ganti blok "Informasi Pegawai" Anda dengan ini --}}
            <div
                class="bg-white rounded-xl shadow-lg transform transition-all duration-300 hover:shadow-2xl mb-6 sm:mb-8">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 sm:mb-8 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pegawai
                    </h3>

                    {{-- PERBAIKAN RESPONSIVE & DINAMIS DIMULAI DI SINI --}}
                    {{-- 1 kolom di layar kecil, 2 kolom di layar medium ke atas --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                        {{-- Loop melalui semua data yang disiapkan di controller --}}
                        @foreach ($pegawaiInfo as $info)
                            <div
                                class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-sm transition-shadow duration-300">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">{{ $info['label'] }}</h4>
                                {{-- Tampilkan 'Tidak ada data' jika nilainya kosong --}}
                                <p class="text-base font-semibold text-gray-900 break-words">
                                    {{ $info['value'] ?? '-' }}
                                </p>
                            </div>
                        @endforeach

                    </div>
                    {{-- PERBAIKAN SELESAI --}}
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

        // --- Real-Time Clock & Attendance Notification Logic ---
        const realtimeClock = document.getElementById('realtimeClock');
        const absenNotification = document.getElementById('absenNotification');

        function pad(num) {
            return num.toString().padStart(2, '0');
        }

        function getTimeStatus(now) {
            // Returns {status, message, type} for absen masuk/pulang
            const hour = now.getHours();
            const minute = now.getMinutes();
            const timeStr = pad(hour) + ':' + pad(minute);
            // Masuk: 08:00 - 10:00
            // Pulang: 16:00 - 16:30
            if (hour < 8) {
                return {
                    status: 'belum_buka',
                    message: 'Absen Masuk dibuka pukul 08:00',
                    type: 'info'
                };
            } else if (hour === 8 || (hour === 9) || (hour === 10 && minute === 0)) {
                if (hour === 10 && minute > 0) {
                    return {
                        status: 'terlambat',
                        message: 'Absen Masuk sudah ditutup. Silakan hubungi admin.',
                        type: 'error'
                    };
                }
                if (hour === 10 && minute === 0) {
                    return {
                        status: 'terlambat',
                        message: 'Absen Masuk Terlambat! (10:00)',
                        type: 'warning'
                    };
                }
                if (hour === 8 && minute === 0) {
                    return {
                        status: 'buka',
                        message: 'Absen Masuk dibuka! Silakan absen.',
                        type: 'success'
                    };
                }
                if (hour === 9 || (hour === 8 && minute > 0)) {
                    return {
                        status: 'buka',
                        message: 'Absen Masuk dibuka! Silakan absen.',
                        type: 'success'
                    };
                }
                return {
                    status: 'buka',
                    message: 'Absen Masuk dibuka! Silakan absen.',
                    type: 'success'
                };
            } else if (hour === 10 && minute > 0 || hour > 10) {
                return {
                    status: 'terlambat',
                    message: 'Absen Masuk sudah ditutup.',
                    type: 'error'
                };
            }
            // Default
            return {
                status: 'unknown',
                message: '',
                type: 'info'
            };
        }

        function getPulangStatus(now) {
            const hour = now.getHours();
            const minute = now.getMinutes();
            if (hour < 16 || (hour === 16 && minute < 0)) {
                return {
                    status: 'belum_buka',
                    message: 'Absen Pulang dibuka pukul 16:00',
                    type: 'info'
                };
            } else if (hour === 16 && minute >= 0 && minute <= 30) {
                return {
                    status: 'buka',
                    message: 'Absen Pulang dibuka! Silakan absen.',
                    type: 'success'
                };
            } else if ((hour === 16 && minute > 30) || hour > 16) {
                return {
                    status: 'tutup',
                    message: 'Absen Pulang sudah ditutup.',
                    type: 'error'
                };
            }
            return {
                status: 'unknown',
                message: '',
                type: 'info'
            };
        }

        function updateClockAndNotification() {
            const now = new Date();
            // Clock
            const jam = pad(now.getHours());
            const menit = pad(now.getMinutes());
            const detik = pad(now.getSeconds());
            realtimeClock.textContent = `${jam}:${menit}:${detik}`;
            realtimeClock.style.color = '#1e40af'; // blue-800
            realtimeClock.style.opacity = '1';
            // Notification logic
            let notif = '';
            let notifType = '';
            let icon = '';
            let showFor = '';
            if (!hasAttendedToday) {
                const masukStatus = getTimeStatus(now);
                notif = masukStatus.message;
                notifType = masukStatus.type;
                showFor = 'masuk';
            } else if (!hasClockedOutToday) {
                const pulangStatus = getPulangStatus(now);
                notif = pulangStatus.message;
                notifType = pulangStatus.type;
                showFor = 'pulang';
            } else {
                notif = 'Terima kasih, absensi hari ini sudah lengkap!';
                notifType = 'success';
            }
            // Icon
            if (notifType === 'success') icon =
                '<svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
            else if (notifType === 'warning') icon =
                '<svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01" /></svg>';
            else if (notifType === 'error') icon =
                '<svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
            else icon =
                '<svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" /></svg>';
            absenNotification.innerHTML = icon + '<span>' + notif + '</span>';
            absenNotification.style.background = notifType === 'success' ? '#dcfce7' : notifType === 'warning' ? '#fef9c3' :
                notifType === 'error' ? '#fee2e2' : '#f8fafc';
            absenNotification.style.color = notifType === 'success' ? '#166534' : notifType === 'warning' ? '#92400e' :
                notifType === 'error' ? '#991b1b' : '#1e293b';
            absenNotification.style.borderColor = notifType === 'success' ? '#bbf7d0' : notifType === 'warning' ?
                '#fde68a' : notifType === 'error' ? '#fecaca' : '#e5e7eb';
            absenNotification.style.opacity = '1';
            // Button state logic
            if (!hasAttendedToday) {
                const masukStatus = getTimeStatus(now);
                if (masukStatus.status === 'buka') {
                    btnAbsenMasuk.disabled = false;
                    btnAbsenMasuk.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btnAbsenMasuk.disabled = true;
                    btnAbsenMasuk.classList.add('opacity-50', 'cursor-not-allowed');
                }
                btnAbsenPulang.disabled = true;
                btnAbsenPulang.classList.add('opacity-50', 'cursor-not-allowed');
            } else if (!hasClockedOutToday) {
                const pulangStatus = getPulangStatus(now);
                if (pulangStatus.status === 'buka') {
                    btnAbsenPulang.disabled = false;
                    btnAbsenPulang.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btnAbsenPulang.disabled = true;
                    btnAbsenPulang.classList.add('opacity-50', 'cursor-not-allowed');
                }
                btnAbsenMasuk.disabled = true;
                btnAbsenMasuk.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btnAbsenMasuk.disabled = true;
                btnAbsenMasuk.classList.add('opacity-50', 'cursor-not-allowed');
                btnAbsenPulang.disabled = true;
                btnAbsenPulang.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
        setInterval(updateClockAndNotification, 1000);
        document.addEventListener('DOMContentLoaded', updateClockAndNotification);

        // --- Enhance checkWifiAndRecord to show friendly time-based messages ---
        async function checkWifiAndRecord(type) {
            const button = (type === 'masuk') ? btnAbsenMasuk : btnAbsenPulang;
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
                    } else if (type === 'pulang') {
                        hasClockedOutToday = true;
                    }
                    updateButtonStates();
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
                updateButtonStates();
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
            try {
                const response = await fetch("{{ route('kehadiran.izin') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
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

        function showIzinModal() {
            const modal = document.getElementById('izinModal');
            modal.classList.remove('hidden');
        }

        function closeIzinModal() {
            const modal = document.getElementById('izinModal');
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

            document.addEventListener('DOMContentLoaded', function() {

                // Definisikan elemen-elemen yang akan diubah
                const statusContainer = document.getElementById('wifiStatus');
                const statusIcon = document.getElementById('wifiIcon');
                const statusText = document.getElementById('wifiText');

                // Definisikan ikon centang dan silang (SVG)
                const iconCentang = `
            <svg class="text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>`;

                const iconSilang = `
            <svg class="text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>`;

                // Fungsi untuk memanggil API backend
                async function periksaStatusJaringan() {
                    try {
                        const response = await fetch('{{ route('kehadiran.cek-jaringan') }}');
                        const data = await response.json();

                        // Hapus class warna default
                        statusContainer.classList.remove('bg-gray-50', 'border-gray-200');

                        if (data.status === 'allowed') {
                            // Jika diizinkan
                            statusIcon.innerHTML = iconCentang;
                            statusText.textContent = 'Terhubung ke jaringan kantor.';
                            statusContainer.classList.add('bg-green-50', 'border-green-300');
                        } else {
                            // Jika ditolak
                            statusIcon.innerHTML = iconSilang;
                            statusText.textContent = 'Tidak terhubung ke jaringan kantor.';
                            statusContainer.classList.add('bg-red-50', 'border-red-300');
                        }

                    } catch (error) {
                        // Jika terjadi error saat fetch
                        console.error('Gagal memeriksa status jaringan:', error);
                        statusIcon.innerHTML = iconSilang;
                        statusText.textContent = 'Gagal memeriksa status jaringan.';
                        statusContainer.classList.add('bg-red-50', 'border-red-300');
                    }
                }

                // Panggil fungsi tersebut
                periksaStatusJaringan();
            });
        }
    </script>
</x-app-layout>

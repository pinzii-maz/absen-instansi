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
                                    <button id="btnAbsenMasuk"
                                        class="flex-1 sm:flex-none flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Absen Masuk
                                    </button>

                                    <button id="btnAbsenPulang"
                                        class="flex-1 sm:flex-none flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/30 disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Absen Pulang
                                    </button>

                                    <button id="btnShowIzinModal"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Information Section -->
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        @foreach ($pegawaiInfo as $info)
                            <div
                                class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-sm transition-shadow duration-300">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">{{ $info['label'] }}</h4>
                                <p class="text-base font-semibold text-gray-900 break-words">
                                    {{ $info['value'] ?? '-' }}
                                </p>
                            </div>
                        @endforeach
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
                                        class="px-4 sm:px-6 py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan Pegawai</th>
                                    <th
                                        class="px-4 sm:px-6 py-3 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Catatan dari Admin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
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
                                                $statusClass =
                                                    [
                                                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                        'disetujui' => 'bg-green-100 text-green-800',
                                                        'ditolak' => 'bg-red-100 text-red-800',
                                                    ][$request->status_izin] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($request->status_izin) }}
                                            </span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-900 break-words">
                                            {{ $request->keterangan_izin }}
                                        </td>
                                        <td class="px-4 sm:px-6 py-4 text-sm text-gray-700 break-words">
                                            @if ($request->status_izin === 'ditolak')
                                                <span
                                                    class="text-red-600 font-medium">{{ $request->alasan_penolakan ?? 'Tidak ada catatan.' }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">
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
                        @foreach ($jenisKehadiran as $jenis)
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
                    <label for="file-upload"
                        class="mt-1 flex justify-center items-center w-full px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-blue-400 transition-colors duration-200">
                        <div id="file-upload-ui" class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-medium text-blue-600">Upload file</span> atau drag and drop
                            </p>
                            <p class="mt-1 text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                        </div>
                    </label>
                    <input id="file-upload" name="surat[]" type="file" class="sr-only" multiple>
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
        document.addEventListener('DOMContentLoaded', function() {
            // =================================================================
            // BAGIAN 1: DEFINISI SEMUA ELEMEN DAN VARIABEL
            // =================================================================
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Elemen-elemen Aksi Utama
            const btnAbsenMasuk = document.getElementById('btnAbsenMasuk');
            const btnAbsenPulang = document.getElementById('btnAbsenPulang');
            const btnShowIzinModal = document.getElementById('btnShowIzinModal');

            // Elemen Modal Izin
            const izinModal = document.getElementById('izinModal');
            const izinForm = document.getElementById('izinForm');
            const btnCloseModal = izinModal?.querySelector('button[onclick="closeIzinModal()"]');
            const btnBatalIzin = izinForm?.querySelector('button[type="button"]');

            const fileInput = document.getElementById('file-upload');
            const fileUploadUI = document.getElementById('file-upload-ui');

            if (fileInput && fileUploadUI) {
                const originalUploadUI = fileUploadUI.innerHTML;

                fileInput.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        if (this.files.length === 1) {
                            const fileName = this.files[0].name;
                            fileUploadUI.innerHTML = `
                                <div class="flex flex-col items-center justify-center text-center">
                                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-700 break-all mt-2">${fileName}</p>
                                    <p class="text-xs text-gray-500 mt-2">Klik lagi untuk mengganti file.</p>
                                </div>
                            `;
                        } else {
                            fileUploadUI.innerHTML = `
                                <div class="flex flex-col items-center justify-center text-center">
                                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-700 break-all mt-2">${this.files.length} file dipilih</p>
                                    <p class="text-xs text-gray-500 mt-2">Klik lagi untuk mengganti file.</p>
                                </div>
                            `;
                        }
                    } else {
                        fileUploadUI.innerHTML = originalUploadUI;
                    }
                });
            }

            // Status Kehadiran dari Server (PHP)
            const hasAttendedToday = {{ session('has_attended_today') ? 'true' : 'false' }};
            const hasClockedOutToday = {{ session('has_clocked_out_today') ? 'true' : 'false' }};

            // =================================================================
            // BAGIAN 2: KUMPULAN SEMUA FUNGSI
            // =================================================================

            // --- Fungsi untuk Notifikasi ---
            function showNotification(message, type) {
                // Buat elemen notifikasi
                const notification = document.createElement('div');
                notification.className = `
                    fixed top-4 right-4 z-50 max-w-sm w-full p-4 rounded-lg shadow-lg
                    transform transition-all duration-300 ease-in-out
                    ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}
                `;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"></path>
                        </svg>
                        <span class="text-sm font-medium">${message}</span>
                    </div>
                `;

                // Tambahkan notifikasi ke body
                document.body.appendChild(notification);

                // Animasi masuk
                setTimeout(() => {
                    notification.classList.add('opacity-100', 'translate-y-0');
                    notification.classList.remove('opacity-0', 'translate-y-4');
                }, 10);

                // Hapus notifikasi setelah 3 detik
                setTimeout(() => {
                    notification.classList.add('opacity-0', 'translate-y-4');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            // --- Fungsi untuk Absensi dan Status ---
            function updateButtonStates() {
                if (!btnAbsenMasuk || !btnAbsenPulang) return;
                const now = new Date();
                const hours = now.getHours();
                const canClockIn = hours >= 8;
                const canClockOut = hours >= 16;

                btnAbsenMasuk.disabled = hasAttendedToday || !canClockIn;
                btnAbsenPulang.disabled = !hasAttendedToday || hasClockedOutToday || !canClockOut;

                [btnAbsenMasuk, btnAbsenPulang].forEach(button => {
                    if (button) {
                        button.classList.toggle('opacity-50', button.disabled);
                        button.classList.toggle('cursor-not-allowed', button.disabled);
                    }
                });
            }

            async function handleAttendance(type) {
                const button = (type === 'masuk') ? btnAbsenMasuk : btnAbsenPulang;
                const route = (type === 'masuk') ? "{{ route('kehadiran.masuk') }}" :
                    "{{ route('kehadiran.pulang') }}";
                const originalButtonText = button.innerHTML;

                button.disabled = true;
                button.innerHTML =
                    `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;

                try {
                    const response = await fetch(route, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    });
                    const result = await response.json();

                    showNotification(result.message, result.success ? 'success' : 'error');

                    if (result.success) {
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        button.innerHTML = originalButtonText;
                        updateButtonStates();
                    }
                } catch (error) {
                    showNotification('Terjadi kesalahan koneksi.', 'error');
                    button.innerHTML = originalButtonText;
                    updateButtonStates();
                }
            }

            // --- Fungsi untuk Modal Izin ---
            function showIzinModal() {
                if (izinModal) izinModal.classList.remove('hidden');
            }

            function closeIzinModal() {
                if (izinModal) izinModal.classList.add('hidden');
                if (izinForm) izinForm.reset();
                if (fileUploadUI) fileUploadUI.innerHTML = originalUploadUI;
            }

            async function handleIzinSubmit(event) {
                event.preventDefault();
                const form = event.target;
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;

                submitButton.disabled = true;
                submitButton.innerHTML =
                    `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...`;

                try {
                    const response = await fetch("{{ route('kehadiran.submit-leave') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        showNotification(data.message, 'success');
                        setTimeout(() => {
                            closeIzinModal();
                            location.reload();
                        }, 1500);
                    } else {
                        showNotification(data.message || 'Terjadi kesalahan validasi.', 'error');
                    }
                } catch (error) {
                    console.error('Submission error:', error);
                    showNotification('Tidak dapat terhubung ke server. Coba lagi nanti.', 'error');
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }

            // =================================================================
            // BAGIAN 3: MENJALANKAN FUNGSI DAN MEMASANG EVENT LISTENERS
            // =================================================================

            if (btnAbsenMasuk) btnAbsenMasuk.addEventListener('click', () => handleAttendance('masuk'));
            if (btnAbsenPulang) btnAbsenPulang.addEventListener('click', () => handleAttendance('pulang'));
            if (btnShowIzinModal) btnShowIzinModal.addEventListener('click', showIzinModal);
            if (izinForm) izinForm.addEventListener('submit', handleIzinSubmit);
            if (btnCloseModal) btnCloseModal.addEventListener('click', closeIzinModal);
            if (btnBatalIzin) btnBatalIzin.addEventListener('click', closeIzinModal);

            updateButtonStates();
            setInterval(updateButtonStates, 60000);
        });
    </script>
</x-app-layout>

<x-app-layout>
    <style>
        :root {
            --background-light: #FFF5F6;
            --background-dark: #111827;
            --card-light: #ffffff;
            --card-dark: #1f2937;
            --text-light: #1a1a1a;
            --text-dark: #f3f4f6;
            --accent-dark: #60a5fa;
            --border-dark: rgba(96, 165, 250, 0.1);
            --gradient-dark-start: #1e40af;
            --gradient-dark-end: #3b82f6;
        }

        body {
            transition: background-color 0.3s ease, color 0.3s ease;
            background-color: var(--background-light);
            min-height: 100vh;
            background: linear-gradient(to bottom right, var(--background-light), #e2e8f0);
        }

        .dark body {
            background: linear-gradient(to bottom right, var(--background-dark), #1a237e);
            color: var(--text-dark);
        }

        .dark .text-gray-800 {
            color: var(--text-dark);
        }

        .dark .bg-white {
            background-color: var(--card-dark);
            border: 1px solid var(--border-dark);
        }

        .dark .text-gray-900 {
            color: var(--text-dark);
        }

        .dark .text-gray-500 {
            color: #9ca3af;
        }

        .dark .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
        }

        .dark .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        .dark .bg-gray-50 {
            background-color: rgba(31, 41, 55, 0.5);
        }

        .dark .bg-indigo-600 {
            background-color: #4f46e5;
        }

        .dark .bg-green-600 {
            background-color: #059669;
        }

        .dark .bg-blue-600 {
            background-color: #2563eb;
        }

        .dark .hover\:bg-indigo-700:hover {
            background-color: #4338ca;
        }

        .dark .hover\:bg-green-700:hover {
            background-color: #047857;
        }

        .dark .hover\:bg-blue-700:hover {
            background-color: #1d4ed8;
        }

        /* Enhanced card styling for dark mode */
        .dark .bg-white.rounded-lg {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-dark);
            transition: all 0.3s ease;
        }

        .dark .bg-white.rounded-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            border-color: var(--accent-dark);
        }

        /* Quick action buttons in dark mode */
        .dark .inline-flex {
            transition: all 0.3s ease;
        }

        .dark .inline-flex:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(96, 165, 250, 0.2);
        }

        /* SVG icons in dark mode */
        .dark svg {
            filter: drop-shadow(0 0 8px rgba(96, 165, 250, 0.2));
        }

        /* Additional styles for attendance features */
        .attendance-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .dark .attendance-card {
            background: rgba(31, 41, 55, 0.8);
            border: 1px solid rgba(96, 165, 250, 0.2);
        }

        .btn-disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .welcome-message {
            font-size: 2rem;
            font-weight: 600;
            background: linear-gradient(45deg, #1a365d, #2563eb);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 30px rgba(37, 99, 235, 0.3);
        }

        .dark .welcome-message {
            background: linear-gradient(45deg, var(--accent-dark), #93c5fd);
            -webkit-background-clip: text;
            background-clip: text;
        }

        /* Button styling */
        .action-button {
            background: linear-gradient(45deg, #2563eb, #1e40af);
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            font-size: 0.875rem;
            border-radius: 0.5rem;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .dark .action-button {
            background: linear-gradient(45deg, var(--gradient-dark-start), var(--gradient-dark-end));
        }

        .dark .action-button:hover {
            box-shadow: 0 10px 20px rgba(96, 165, 250, 0.2);
        }

        /* Status indicators */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .status-indicator {
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(96, 165, 250, 0.2);
        }

        /* Floating animation */
        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, 15px);
            }

            100% {
                transform: translate(0, 0px);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .welcome-message {
                font-size: 1.5rem;
            }

            .dashboard-card {
                padding: 1rem;
            }

            .action-button {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
        }

        /* Modal styling */
        .modal-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .dark .modal-content {
            background: rgba(31, 41, 55, 0.9);
            border: 1px solid rgba(96, 165, 250, 0.2);
        }

        /* Clock styling */
        .clock-container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            margin-bottom: 1rem;
        }

        .dark .clock-container {
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(96, 165, 250, 0.2);
        }

        .clock-text {
            background: linear-gradient(45deg, #2563eb, #1d4ed8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .dark .clock-text {
            background: linear-gradient(45deg, var(--accent-dark), #93c5fd);
        }

        /* Select element styling */
        select {
            background-color: var(--card-light) !important;
            color: var(--text-light) !important;
            border: 1px solid #e5e7eb !important;
            padding: 0.5rem !important;
            border-radius: 0.5rem !important;
            width: 100% !important;
            cursor: pointer !important;
        }

        .dark select {
            background-color: var(--card-dark) !important;
            color: var(--text-dark) !important;
            border-color: var(--border-dark) !important;
        }

        select:focus {
            outline: none !important;
            border-color: var(--accent-dark) !important;
            ring: 2px var(--accent-dark) !important;
        }

        /* Override default date input styling */
        input[type="date"] {
            appearance: none;
            -webkit-appearance: none;
            color: #374151;
            background-color: #ffffff;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            background-color: #ffffff;
            padding: 5px;
            cursor: pointer;
            border-radius: 3px;
        }

        /* Override default select styling */
        select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        select::-ms-expand {
            display: none;
        }

        /* Theme toggle button */
        .theme-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
            padding: 0.75rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(8deg);
        }

        .dark .theme-toggle {
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(96, 165, 250, 0.2);
            color: var(--accent-dark);
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

        .dark .bg-pattern {
            background-image:
                radial-gradient(circle at 15% 50%, rgba(37, 99, 235, 0.2) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(29, 78, 216, 0.2) 0%, transparent 25%),
                radial-gradient(circle at 50% 80%, rgba(30, 64, 175, 0.2) 0%, transparent 25%);
        }

        @keyframes patternMove {
            0% {
                transform: scale(1) rotate(0deg);
            }

            50% {
                transform: scale(1.1) rotate(1deg);
            }

            100% {
                transform: scale(1) rotate(0deg);
            }
        }
    </style>

    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <!-- Main Content -->
    <div class="relative min-h-screen z-10 py-12 px-4 sm:px-6 lg:px-8"
        style="background: linear-gradient(135deg, #f6f8fc 0%, #e9edf5 100%);">
        <div class="max-w-7xl mx-auto">



            <!-- Welcome and Attendance Section -->
            <div class="bg-white rounded-xl shadow-xl mb-8 transform transition-all duration-300 hover:shadow-2xl">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <!-- Left side - Illustration -->
                        <div class="flex justify-center">
                            <img src="images/icon_Dashboard.png" alt="Attendance Illustration"
                                class="max-w-full h-auto max-h-64 floating">
                        </div>

                        <!-- Right side - Welcome Message and Attendance Status -->
                        <div class="space-y-6">
                            <div class="welcome-message" data-aos="fade-up">
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                                    @if (!session('has_attended_today'))
                                        Selamat Datang, {{ auth()->user()->name }}!
                                    @else
                                        Selamat Bertugas, {{ auth()->user()->name }}!
                                    @endif
                                </h1>
                                <p class="text-lg text-gray-600">
                                    @if (!session('has_attended_today'))
                                        Jangan lupa absen hari ini ya!
                                    @else
                                        Semoga Harimu Menyenangkan
                                    @endif
                                </p>
                            </div>

                            <!-- Statistics Cards -->
                            <div class="grid grid-cols-2 gap-4 mt-8" data-aos="fade-up" data-aos-delay="200">
                                <div class="stats-card p-4 rounded-lg shadow-lg card-hover">
                                    <div class="text-3xl font-bold text-blue-600">{{ $totalAttendance ?? 0 }}</div>
                                    <div class="text-sm text-gray-600">Total Kehadiran Bulan Ini</div>
                                </div>
                                <div class="stats-card p-4 rounded-lg shadow-lg card-hover">
                                    <div class="text-3xl font-bold text-blue-600">{{ $onTimePercentage ?? 0 }}%</div>
                                    <div class="text-sm text-gray-600">Tepat Waktu</div>
                                </div>
                            </div>

                            <!-- Attendance Actions -->
                            <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                                <div class="flex flex-wrap gap-4">
                                    <button id="btnAbsenMasuk" onclick="checkWifiAndRecord('masuk')"
                                        class="flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Absen Masuk
                                    </button>

                                    <button id="btnAbsenPulang" onclick="checkWifiAndRecord('pulang')"
                                        class="flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/30 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Absen Pulang
                                    </button>

                                    <button onclick="showIzinModal()"
                                        class="flex items-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all duration-300 shadow-lg hover:shadow-gray-500/30">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        Ajukan Izin
                                    </button>
                                </div>

                                <div id="wifiStatus"
                                    class="mt-4 bg-white rounded-lg p-4 shadow-md border border-gray-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500 animate-spin" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span class="text-gray-700">Memeriksa koneksi WiFi...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Employee Information Section -->
            <div class="bg-white rounded-xl shadow-xl transform transition-all duration-300 hover:shadow-2xl">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-800" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pegawai
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="space-y-6">
                            <div
                                class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Nama Lengkap</h4>
                                <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            </div>
                            <div
                                class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Email</h4>
                                <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->email }}</p>
                            </div>
                            <div
                                class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">NIP</h4>
                                <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->nip }}</p>
                            </div>
                        </div>

                        <!-- Position Information -->
                        <div class="space-y-6">
                            <div
                                class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                <h4 class="text-sm font-medium text-gray-500 mb-1">Jabatan</h4>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</p>
                            </div>

                            @if (auth()->user()->role === 'pelaksana')
                                <div
                                    class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                    <h4 class="text-sm font-medium text-gray-500 mb-1">Unit Kerja</h4>
                                    <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->unit_kerja }}</p>
                                </div>
                                <div
                                    class="bg-gray-50 rounded-lg p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                    <h4 class="text-sm font-medium text-gray-500 mb-1">Jabatan Fungsional</h4>
                                    <p class="text-lg font-semibold text-gray-800">
                                        {{ auth()->user()->jabatan_fungsional }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Leave Request Modal -->
    <div id="izinModal" class="fixed inset-0 bg-black bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-8 border w-[480px] shadow-2xl rounded-xl bg-white">
            <div class="absolute top-4 right-4">
                <button onclick="closeIzinModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Ajukan Izin</h3>
                <p class="text-gray-600 mt-1">Silakan lengkapi form berikut untuk mengajukan izin</p>
            </div>

            <form id="izinForm" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Izin</label>
                    <select name="jenis_izin"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                        <option value=""disabled selected>Pilih jenis izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="dinas_luar">Dinas Luar</option>
                        <option value="cuti">Tugas Luar</option>
                        <option value="cuti">Cuti</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            class="block w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 border-gray-300 bg-white px-4 py-2.5 text-gray-700">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-700 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all  text-gray-700"
                        placeholder="Tuliskan alasan izin Anda..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Surat Pendukung</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48">
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

                <div class="flex justify-end space-x-4 mt-8">
                    <button type="button" onclick="closeIzinModal()"
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/30">
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

        // File upload handling di modal izin (opsional, untuk menampilkan nama file)
        const fileUploadInput = document.getElementById('file-upload');
        if (fileUploadInput) {
            fileUploadInput.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : 'atau drag and drop';
                // Anda mungkin perlu elemen khusus untuk menampilkan nama file
                const fileDropText = this.closest('.flex.text-sm.text-gray-600').querySelector('p.pl-1');
                if (fileDropText) fileDropText.textContent = fileName;
            });
        }
    </script>
</x-app-layout>

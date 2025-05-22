<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pegawai</h3>
                        
                        <!-- Profile Card -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Basic Information -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Nama Lengkap</h4>
                                        <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                        <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-500">NIP</h4>
                                        <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->nip }}</p>
                                    </div>
                                </div>

                                <!-- Position Information -->
                                <div>
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-500">Jabatan</h4>
                                        <p class="text-lg font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</p>
                                    </div>
                                    
                                    @if(auth()->user()->role === 'pelaksana')
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">Unit Kerja</h4>
                                            <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->unit_kerja }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <h4 class="text-sm font-medium text-gray-500">Jabatan Fungsional</h4>
                                            <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->jabatan_fungsional }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit Profile
                                </a>
                                
                                <button class="inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Lihat Absensi
                                </button>
                                
                                <button class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Jadwal Kerja
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add any interactive features here
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add hover effects to cards
            const cards = document.querySelectorAll('.bg-white.rounded-lg');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.classList.add('transform', 'scale-[1.02]', 'transition-transform');
                });
                card.addEventListener('mouseleave', function() {
                    this.classList.remove('transform', 'scale-[1.02]', 'transition-transform');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>

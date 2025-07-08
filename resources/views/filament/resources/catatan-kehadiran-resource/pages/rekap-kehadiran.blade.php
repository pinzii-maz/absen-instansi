<x-filament-panels::page>
    {{-- Bagian 1: Form Filter --}}
    <form wire:submit.prevent="generateReport" class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{ $this->form }}
        </div>
    </form>

    {{-- Bagian 2: Ringkasan Jumlah Pegawai --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border-l-4 border-gray-500">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah Pegawai</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $this->summary['total'] }} Orang</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">PNS</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $this->summary['pns'] }} Orang</p>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border-l-4 border-teal-500">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Non-PNS</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $this->summary['non_pns'] }} Orang</p>
        </div>
    </div>

    {{-- Bagian 3: Tabel Rekapitulasi --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th rowspan="2" class="px-4 py-3 border dark:border-gray-600 text-center">No</th>
                    <th rowspan="2" class="px-6 py-3 border dark:border-gray-600">Nama</th>
                    <th rowspan="2" class="px-4 py-3 border dark:border-gray-600 text-center">Hadir</th>
                    <th colspan="6" class="px-6 py-3 border dark:border-gray-600 text-center">Keterangan Tidak Hadir
                    </th>
                </tr>
                <tr>
                    <th class="px-2 py-2 border dark:border-gray-600 text-center bg-red-200 dark:bg-red-800/50">S</th>
                    <th class="px-2 py-2 border dark:border-gray-600 text-center bg-yellow-200 dark:bg-yellow-800/50">I
                    </th>
                    <th class="px-2 py-2 border dark:border-gray-600 text-center bg-red-200 dark:bg-red-800/50">C</th>
                    <th class="px-2 py-2 border dark:border-gray-600 text-center bg-green-200 dark:bg-green-800/50">DL
                    </th>
                    <th class="px-2 py-2 border dark:border-gray-600 text-center bg-orange-200 dark:bg-orange-800/50">TL
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->data as $pegawai)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="px-4 py-2 border dark:border-gray-700 text-center">{{ $loop->iteration }}</td>
                        <td
                            class="px-6 py-2 border dark:border-gray-700 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $pegawai->name }}</td>
                        <td class="px-4 py-2 border dark:border-gray-700 text-center">{{ $pegawai->hadir_count }}</td>
                        <td class="px-4 py-2 border dark:border-gray-700 text-center bg-red-100 dark:bg-red-900/50">
                            {{ $pegawai->sakit_count }}</td>
                        <td
                            class="px-4 py-2 border dark:border-gray-700 text-center bg-yellow-100 dark:bg-yellow-900/50">
                            {{ $pegawai->izin_count }}</td>
                        <td class="px-4 py-2 border dark:border-gray-700 text-center bg-red-100 dark:bg-red-900/50">
                            {{ $pegawai->cuti_count }}</td>
                        <td class="px-4 py-2 border dark:border-gray-700 text-center bg-green-100 dark:bg-green-900/50">
                            {{ $pegawai->dinas_luar_count }}</td>
                        <td
                            class="px-4 py-2 border dark:border-gray-700 text-center bg-orange-100 dark:bg-orange-900/50">
                            {{ $pegawai->tugas_luar_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data kehadiran untuk periode dan status yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament-panels::page>

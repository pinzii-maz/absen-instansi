<x-filament-panels::page>
    {{-- Bagian Filter (tidak ada perubahan, sudah benar) --}}
    <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
        <form wire:submit="filterData" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="tanggal_mulai" class="text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal
                    Mulai</label>
                <input type="date" id="tanggal_mulai" wire:model.live="tanggal_mulai"
                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div>
                <label for="tanggal_selesai" class="text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal
                    Selesai</label>
                <input type="date" id="tanggal_selesai" wire:model.live="tanggal_selesai"
                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600">
            </div>
            <div>
                <label for="status_pegawai" class="text-sm font-medium text-gray-700 dark:text-gray-200">Status
                    Pegawai</label>
                <select id="status_pegawai" wire:model.live="status_pegawai"
                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                    <option value="semua">Semua</option>
                    <option value="pns">PNS</option>
                    <option value="non_pns">Non-PNS</option>
                </select>
            </div>
            <div>
                <button type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
            </div>
        </form>
    </div>

    {{-- ✅ BAGIAN TABEL KITA UBAH TOTAL --}}
    <div class="mt-6 overflow-x-auto bg-white rounded-xl shadow dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Nama Pegawai</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Divisi</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Jabatan (Role)</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Rekap DL/TL</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                {{-- Loop sekarang menggunakan $daftarPegawai --}}
                @forelse ($daftarPegawai as $pegawai)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $pegawai->name }}</div>
                            {{-- Tampilkan NIP jika ada --}}
                            @if ($pegawai->nip)
                                <div class="text-xs text-gray-500">{{ $pegawai->nip }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{-- Tampilkan status PNS/Non-PNS berdasarkan NIP --}}
                            {{ $pegawai->nip ? 'PNS' : 'Non-PNS' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{-- Tampilkan nama divisi, beri tanda '-' jika kosong --}}
                            {{ $pegawai->divisi->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{-- Ubah format role agar lebih mudah dibaca --}}
                            {{ Str::of($pegawai->role)->replace('_', ' ')->title() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{-- Tampilkan rekap DL dan TL dengan warna --}}
                            <div class="flex items-center gap-2">
                                @if ($pegawai->dinas_luar_count > 0)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $pegawai->dinas_luar_count }} DL
                                    </span>
                                @endif
                                @if ($pegawai->tugas_luar_count > 0)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $pegawai->tugas_luar_count }} TL
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">Tidak ada data
                            pegawai yang cocok dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-filament-panels::page>

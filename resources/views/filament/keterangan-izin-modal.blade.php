<div>
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
        Detail Pengajuan Izin
    </h3>

    {{-- 'prose' akan memberikan styling otomatis untuk paragraf --}}
    <div class="prose prose-sm max-w-none text-gray-700 dark:text-gray-300">
        <p>
            {{ $record->keterangan_izin }}
        </p>
    </div>

    {{-- Tampilkan link ke dokumen pendukung jika ada --}}
    @if ($record->file_pendukung_izin)
        <div class="mt-4">
            <a href="{{ Illuminate\Support\Facades\Storage::url($record->file_pendukung_izin) }}" target="_blank"
                class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-500">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.497a.75.75 0 00-1.06-1.06l-.497.497a1.5 1.5 0 01-2.122-2.122l7-7a1.5 1.5 0 012.122 0r"
                        clip-rule="evenodd" />
                </svg>
                Lihat Dokumen Pendukung
            </a>
        </div>
    @endif

    {{-- Tampilkan detail approver jika izin sudah diproses --}}
    @if ($record->approver)
        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-md font-semibold text-gray-800 dark:text-white mb-1">
                Diproses oleh:
            </h4>
            <p class="text-gray-600 dark:text-gray-400">{{ $record->approver->name }}</p>
        </div>
    @endif
</div>

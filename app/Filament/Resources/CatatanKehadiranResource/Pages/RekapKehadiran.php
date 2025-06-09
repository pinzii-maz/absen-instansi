<?php

namespace App\Filament\Resources\CatatanKehadiranResource\Pages;

use App\Filament\Resources\CatatanKehadiranResource;
use App\Models\User;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Collection;

class RekapKehadiran extends Page {
    protected static string $resource = CatatanKehadiranResource::class;
    protected static string $view = 'filament.resources.catatan-kehadiran-resource.pages.rekap-kehadiran';
    protected static ?string $title = 'Rekapitulasi Kehadiran';

    public ?string $tanggal_mulai = null;
    public ?string $tanggal_selesai = null;

    public string $status_pegawai = 'semua';

    public Collection $daftarPegawai;

    public function mount(): void {
        $this->tanggal_mulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = now()->endOfMonth()->format('Y-m-d');
        $this->filterData();
    }

    
    public function filterData(): void
    {
          $query = User::query()
        ->with('divisi')
        // Menghitung jumlah Dinas Luar (DL) yang disetujui
        ->withCount(['catatanKehadiran as dinas_luar_count' => function ($query) {
            $query->whereBetween('tanggal_masuk', [$this->tanggal_mulai, $this->tanggal_selesai])
                  ->where('status_izin', 'disetujui') // ✅ HANYA HITUNG YANG DISETUJUI
                  ->whereHas('jenisKehadiran', fn($q) => $q->where('code', 'DL'));
        }])
        // Menghitung jumlah Tugas Luar (TL) yang disetujui
        ->withCount(['catatanKehadiran as tugas_luar_count' => function ($query) {
            $query->whereBetween('tanggal_masuk', [$this->tanggal_mulai, $this->tanggal_selesai]) // ✅ PERBAIKAN TYPO
                  ->where('status_izin', 'disetujui') // ✅ HANYA HITUNG YANG DISETUJUI
                  ->whereHas('jenisKehadiran', fn($q) => $q->where('code', 'TL'));
        }]);

    // Filter status kepegawaian (logika ini sudah benar)
    if ($this->status_pegawai === 'pns') {
        $query->whereNotNull('nip')->where('nip', '!=', '');
    } elseif ($this->status_pegawai === 'non_pns') {
        $query->whereNull('nip')->orWhere('nip', '=', '');
    }

    $this->daftarPegawai = $query->orderBy('name')->get();
    }
}
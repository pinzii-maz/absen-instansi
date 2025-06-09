<?php

namespace App\Filament\Resources\CatatanKehadiranResource\Pages;

use App\Exports\RekapPegawaiExport;
use App\Filament\Resources\CatatanKehadiranResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class RekapKehadiran extends Page
{
    protected static string $resource = CatatanKehadiranResource::class;
    protected static string $view = 'filament.resources.catatan-kehadiran-resource.pages.rekap-kehadiran';
    protected static ?string $title = 'Rekapitulasi Kehadiran';

    public ?string $tanggal_mulai = null;
    public ?string $tanggal_selesai = null;
    public string $status_pegawai = 'semua';
    public Collection $daftarPegawai;

    public function mount(): void
    {
        $this->tanggal_mulai = now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = now()->endOfMonth()->format('Y-m-d');
        $this->filterData();
    }

    // ✅ Method filterData sekarang menjadi lebih sederhana
    public function filterData(): void
    {
        $this->daftarPegawai = $this->getFilteredQuery()->orderBy('name')->get();
    }

    // ✅ KITA BUAT METHOD BARU UNTUK QUERY YANG BISA DIPAKAI ULANG
    protected function getFilteredQuery(): Builder
    {
        $query = User::query()
            ->with('divisi')
            ->withCount([
                'catatanKehadiran as hadir_penuh_count' => function ($query) {
                    $query->whereBetween('tanggal_masuk', [$this->tanggal_mulai, $this->tanggal_selesai])
                        ->whereNotNull('jam_masuk')
                        ->whereNotNull('jam_pulang');
                },
                'catatanKehadiran as dinas_luar_count' => function ($query) {
                    $query->whereBetween('tanggal_masuk', [$this->tanggal_mulai, $this->tanggal_selesai])
                        ->where('status_izin', 'disetujui')
                        ->whereHas('jenisKehadiran', fn($q) => $q->where('code', 'DL'));
                },
                'catatanKehadiran as tugas_luar_count' => function ($query) {
                    $query->whereBetween('tanggal_masuk', [$this->tanggal_mulai, $this->tanggal_selesai])
                        ->where('status_izin', 'disetujui')
                        ->whereHas('jenisKehadiran', fn($q) => $q->where('code', 'TL'));
                }
            ]);

        if ($this->status_pegawai === 'pns') {
            $query->whereNotNull('nip')->where('nip', '!=', '');
        } elseif ($this->status_pegawai === 'non_pns') {
            $query->whereNull('nip')->orWhere('nip', '=', '');
        }
        
        return $query;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_excel')
                ->label('Ekspor Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    // ✅ PANGGIL METHOD QUERY BARU KITA DI SINI
                    $dataToExport = $this->getFilteredQuery()->orderBy('name')->get();
                    
                    $fileName = 'rekap-kehadiran-' . now()->format('d-m-Y') . '.xlsx';
                    
                    return Excel::download(new RekapPegawaiExport($dataToExport), $fileName);
                }),
            // Anda bisa menambahkan aksi ekspor PDF di sini nanti dengan cara yang sama
        ];
    }
}
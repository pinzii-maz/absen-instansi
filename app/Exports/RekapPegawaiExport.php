<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapPegawaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $pegawai;

    // Kita akan mengirimkan data yang sudah difilter dari controller ke sini
    public function __construct(Collection $pegawai)
    {
        $this->pegawai = $pegawai;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Memberitahu Excel untuk menggunakan koleksi data yang sudah kita filter
        return $this->pegawai;
    }

    /**
     * @var User $pegawai
     */
    public function map($pegawai): array
    {
        // Mengatur data apa saja yang akan ditampilkan di setiap baris
        return [
            $pegawai->name,
            $pegawai->nip,
            $pegawai->nip ? 'PNS' : 'Non-PNS',
            $pegawai->divisi->name ?? '-',
            Str::of($pegawai->role)->replace('_', ' ')->title(),
            $pegawai->hadir_penuh_count,
            $pegawai->dinas_luar_count,
            $pegawai->tugas_luar_count,
        ];
    }
    
    public function headings(): array
    {
        // Membuat baris header untuk file Excel
        return [
            'Nama Pegawai',
            'NIP',
            'Status',
            'Divisi',
            'Jabatan',
            'Total Hadir Penuh',
            'Total Dinas Luar',
            'Total Tugas Luar',
        ];
    }
}
<?php
namespace App\Filament\Resources\CatatanKehadiranResource\Pages;

use App\Filament\Resources\CatatanKehadiranResource;
use App\Models\CatatanKehadiran;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action; 
use App\Exports\RekapKehadiranExport; 
use Maatwebsite\Excel\Facades\Excel; 

class RekapKehadiran extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = CatatanKehadiranResource::class;
    protected static string $view = 'filament.resources.catatan-kehadiran-resource.pages.rekap-kehadiran';
    protected static ?string $title = 'Rekapitulasi Laporan Daftar Hadir';

    // Properti untuk menyimpan data filter dan hasil laporan
    public $statusKepegawaian;
    public $bulan;
    public $tahun;

    public $data = [];
    public $summary = [
        'total' => 0,
        'pns' => 0,
        'non_pns' => 0,
    ];

    // Method yang dijalankan saat halaman pertama kali dimuat
    public function mount(): void
    {
        $this->form->fill([
            'statusKepegawaian' => 'semua',
            'bulan' => now()->month,
            'tahun' => now()->year,
        ]);
        $this->generateReport();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Download Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(fn () => $this->export()),
        ];
    }

     public function export()
    {
        $this->generateReport(); // Pastikan data terbaru yang diekspor
        
        $bulanNama = Carbon::create()->month($this->bulan)->translatedFormat('F');
        $status = $this->statusKepegawaian;
        $fileName = "Rekap Kehadiran {$status} - {$bulanNama} {$this->tahun}.xlsx";

        return Excel::download(new RekapKehadiranExport($this->data, $this->bulan, $this->tahun, $this->summary), $fileName);
    }

    // Mendefinisikan form filter di bagian atas halaman
    protected function getFormSchema(): array
    {
        return [
            Select::make('statusKepegawaian')
                ->label('Status Kepegawaian')
                ->options([
                    'semua' => 'Semua Pegawai',
                    'pns' => 'PNS',
                    'non_pns' => 'Non-PNS',
                ])
                ->default('semua')
                ->reactive()
                ->afterStateUpdated(fn () => $this->generateReport()),

            Select::make('bulan')
                ->label('Pilih Bulan')
                ->options(collect(range(1, 12))->mapWithKeys(fn ($m) => [$m => Carbon::create()->month($m)->translatedFormat('F')]))
                ->default(now()->month)
                ->reactive()
                ->afterStateUpdated(fn () => $this->generateReport()),

            Select::make('tahun')
                ->label('Pilih Tahun')
                ->options(collect(range(now()->year, 2020))->mapWithKeys(fn ($y) => [$y => $y]))
                ->default(now()->year)
                ->reactive()
                ->afterStateUpdated(fn () => $this->generateReport()),
        ];
    }

    // Fungsi utama untuk mengambil dan memproses data laporan
    public function generateReport(): void
    {
        // Ambil data dari form
        $state = $this->form->getState();
        $this->statusKepegawaian = $state['statusKepegawaian'];
        $this->bulan = $state['bulan'];
        $this->tahun = $state['tahun'];

        // Hitung ringkasan jumlah pegawai
        $this->summary['pns'] = User::whereNotNull('nip')->count();
        $this->summary['non_pns'] = User::whereNull('nip')->count();
        $this->summary['total'] = $this->summary['pns'] + $this->summary['non_pns'];

        // Query utama untuk mengambil data pegawai beserta rekap kehadirannya
        $query = User::query();

        // Terapkan filter status kepegawaian
        if ($this->statusKepegawaian === 'pns') {
            $query->whereNotNull('nip');
        } elseif ($this->statusKepegawaian === 'non_pns') {
            $query->whereNull('nip');
        }

        // Ambil data pegawai dengan menghitung jumlah setiap jenis kehadiran
        // menggunakan withCount yang sangat efisien
        $this->data = $query->withCount([
            'catatanKehadiran as hadir_count' => fn(Builder $q) => $q->whereMonth('tanggal_masuk', $this->bulan)->whereYear('tanggal_masuk', $this->tahun)->whereHas('jenisKehadiran', fn($sub) => $sub->whereIn('code', ['H', 'T'])),
            'catatanKehadiran as sakit_count' => fn(Builder $q) => $q->whereMonth('tanggal_masuk', $this->bulan)->whereYear('tanggal_masuk', $this->tahun)->whereHas('jenisKehadiran', fn($sub) => $sub->where('code', 'S')),
            'catatanKehadiran as izin_count' => fn(Builder $q) => $q->whereMonth('tanggal_masuk', $this->bulan)->whereYear('tanggal_masuk', $this->tahun)->whereHas('jenisKehadiran', fn($sub) => $sub->where('code', 'I')),
            'catatanKehadiran as cuti_count' => fn(Builder $q) => $q->whereMonth('tanggal_masuk', $this->bulan)->whereYear('tanggal_masuk', $this->tahun)->whereHas('jenisKehadiran', fn($sub) => $sub->where('code', 'C')),
            'catatanKehadiran as dinas_luar_count' => fn(Builder $q) => $q->whereMonth('tanggal_masuk', $this->bulan)->whereYear('tanggal_masuk', $this->tahun)->whereHas('jenisKehadiran', fn($sub) => $sub->where('code', 'DL')),
            'catatanKehadiran as tugas_luar_count' => fn(Builder $q) => $q->whereMonth('tanggal_masuk', $this->bulan)->whereYear('tanggal_masuk', $this->tahun)->whereHas('jenisKehadiran', fn($sub) => $sub->where('code', 'TL')),
        ])->get();
    }
}

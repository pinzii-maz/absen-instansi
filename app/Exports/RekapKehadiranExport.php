<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class RekapKehadiranExport implements FromView, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $bulan;
    protected $tahun;
    protected $summary;

    public function __construct($data, $bulan, $tahun, $summary)
    {
        $this->data = $data;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->summary = $summary;
    }

    public function view(): View
    {
        return view('exports.rekap-kehadiran', [
            'data' => $this->data,
            'bulan' => Carbon::create()->month($this->bulan)->translatedFormat('F'),
            'tahun' => $this->tahun,
            'summary' => $this->summary,
        ]);
    }

    public function title(): string
    {
        $bulanNama = Carbon::create()->month($this->bulan)->translatedFormat('F');
        return "Rekap {$bulanNama} {$this->tahun}";
    }
}

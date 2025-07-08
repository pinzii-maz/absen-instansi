<table>
    <thead>
        {{-- Baris Judul --}}
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 16px; text-align: center;">REKAPITULASI LAPORAN DAFTAR
                HADIR</th>
        </tr>
        <tr>
            <th colspan="8" style="font-weight: bold; font-size: 14px; text-align: center;">BULAN
                {{ strtoupper($bulan) }} TAHUN {{ $tahun }}</th>
        </tr>
        <tr></tr> {{-- Baris kosong sebagai spasi --}}

        {{-- Baris Ringkasan --}}
        <tr>
            <th colspan="2">Jumlah Pegawai: {{ $summary['total'] }}</th>
        </tr>
        <tr>
            <th colspan="2">PNS: {{ $summary['pns'] }}</th>
        </tr>
        <tr>
            <th colspan="2">Non-PNS: {{ $summary['non_pns'] }}</th>
        </tr>
        <tr></tr> {{-- Baris kosong sebagai spasi --}}

        {{-- Baris Header Tabel --}}
        <tr>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">No</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Nama</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">Hadir</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">S</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">I</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">C</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">DL</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">TL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $pegawai)
            <tr>
                <td style="border: 1px solid #000; text-align: center;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #000;">{{ $pegawai->name }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $pegawai->hadir_count }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $pegawai->sakit_count }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $pegawai->izin_count }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $pegawai->cuti_count }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $pegawai->dinas_luar_count }}</td>
                <td style="border: 1px solid #000; text-align: center;">{{ $pegawai->tugas_luar_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

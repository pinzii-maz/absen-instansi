<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\JenisKehadiran;
use Illuminate\Database\Seeder;

class JenisKehadiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisKehadiran::updateOrCreate(['code' => 'H'], ['name' => 'Hadir (Masuk)', 'diperbolehkan_di_luar_jaringan' => false]);
        JenisKehadiran::updateOrCreate(['code' => 'T'], ['name' => 'Terlambat', 'diperbolehkan_di_luar_jaringan' => false]); // ✅ TAMBAHKAN BARIS INI
        JenisKehadiran::updateOrCreate(['code' => 'P'], ['name' => 'Hadir (Pulang)', 'diperbolehkan_di_luar_jaringan' => false]);
        JenisKehadiran::updateOrCreate(['code' => 'S'], ['name' => 'Sakit', 'diperbolehkan_di_luar_jaringan' => true]);
        JenisKehadiran::updateOrCreate(['code' => 'I'], ['name' => 'Izin Lainnya', 'diperbolehkan_di_luar_jaringan' => true]);
        JenisKehadiran::updateOrCreate(['code' => 'DL'],['name' => 'Dinas Luar', 'diperbolehkan_di_luar_jaringan' => true]);
        JenisKehadiran::updateOrCreate(['code' => 'TL'],['name' => 'Tugas Luar', 'diperbolehkan_di_luar_jaringan' => true]);
        JenisKehadiran::updateOrCreate(['code' => 'C'], ['name' => 'Cuti', 'diperbolehkan_di_luar_jaringan' => true]);
    }
    }

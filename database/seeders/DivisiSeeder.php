<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $utama = Divisi::create([
            'name' => 'Biro Administrasi Pimpinan',
            'parent_id' => null,
        ]);

        Divisi::insert([
            ['name' => 'Bagian Perencanaan dan Kepegawaian', 'parent_id' => $utama->id],
            ['name' => 'Bagian Protokol', 'parent_id' => $utama->id],
            ['name' => 'Bagian Materi dan Komunikasi Pimpinan', 'parent_id' => $utama->id],
            ['name' => 'Subbag Tata Usaha', 'parent_id' => $utama->id],
        ]);
    }
} 
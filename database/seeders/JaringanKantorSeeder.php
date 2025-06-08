<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\JaringanKantor;
use Illuminate\Database\Seeder;

class JaringanKantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            JaringanKantor::updateOrCreate(
                ['name' => 'Semanggi Putra 2'],
        [ // Hanya satu array untuk data
            'ssid' => 'semanggi putra 2',
            'ip_cidr' => '192.168.1.0/24'
        ]
            );
        }
}
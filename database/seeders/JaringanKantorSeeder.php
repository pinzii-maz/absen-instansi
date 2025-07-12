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
                ['name' => 'BIRO-HUMAS-II'], 
        [ // Hanya satu array untuk data
            'ssid' => 'BIRO-HUMAS-II',
            'ip_cidr' => '172.16.31.82',
        ]
            );
        }
} 
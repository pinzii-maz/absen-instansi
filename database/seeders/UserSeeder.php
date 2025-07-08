<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisi = Divisi::first(); // ambil satu divisi dulu

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'nip' => '123456789',
            'divisi_id' => $divisi->id,
            'role' => 'kepala_biro',
            'password' => Hash::make('password'),
        ]);
    }
}

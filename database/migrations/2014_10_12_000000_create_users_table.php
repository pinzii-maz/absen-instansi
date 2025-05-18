<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nip')->nullable()->unique();
            $table->foreignId('divisi_id')->constrained('divisi');
            $table->enum('role', [ 
                    'kepala_biro',
                    'kepala_bagian_perencanaan_dan_kepegawaian',
                    'kepala_bagian_protokol',
                    'kepala_bagian_materi_dan_komunikasi_pimpinan',
                    'kepala_sub_bagian_tata_usaha',
                    'analisi_kebijakan_ahli_muda',
                    'pranata_hubungan_masyarakat_ahli_muda',
                    'pelaksana'
                ]);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

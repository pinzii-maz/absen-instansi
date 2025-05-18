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
        Schema::create('catatan_kehadiran_tabel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->tinyInteger('jenis_kehadiran_id')
                ->constrained('jenis_kehadiran');
            $table->date('tanggal');
            $table->string('tanda_tangan');       
            $table->foreignId('permintaan_cuti_id')  
                ->nullable()
                ->constrained('permintaan_cuti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_kehadiran_tabel');
    }
};

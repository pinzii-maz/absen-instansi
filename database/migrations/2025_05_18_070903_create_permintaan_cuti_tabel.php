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
        Schema::create('permintaan_cuti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users');
            $table->tinyInteger('attendance_type_id')
                ->constrained('attendance_types');
            $table->date('tanggal_dimulai');
            $table->date('tanggal_diakhiri');
            $table->string('dokumen_path');
            $table->enum('status', ['proses','disetujui','ditolak'])
                ->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_cuti_tabel');
    }
};

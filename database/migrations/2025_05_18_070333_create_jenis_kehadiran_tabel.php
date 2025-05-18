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
        Schema::create('jenis_kehadiran', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('diperbolehkan_di_luar_jaringan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_kehadiran_tabel');
    }
};

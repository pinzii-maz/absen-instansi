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
        Schema::create('catatan_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            
            $table->unsignedTinyInteger('jenis_kehadiran_id'); 
            $table->foreign('jenis_kehadiran_id')->references('id')->on('jenis_kehadiran');
            
            $table->date('tanggal_masuk')->nullable();      
            $table->time('jam_masuk')->nullable();          
            $table->string('ip_address_masuk')->nullable(); 

            
            $table->unsignedTinyInteger('jenis_kehadiran_id_pulang')->nullable(); 
            $table->foreign('jenis_kehadiran_id_pulang')->references('id')->on('jenis_kehadiran');
            $table->time('jam_pulang')->nullable();             
            $table->string('ip_address_pulang')->nullable();
            
            // Untuk Izin
            $table->date('tanggal_selesai_izin')->nullable();       
            $table->text('keterangan_izin')->nullable();
            $table->string('file_pendukung_izin')->nullable(); 

            $table->text('catatan_tambahan')->nullable();
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

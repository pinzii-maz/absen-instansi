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
        Schema::table('catatan_kehadiran', function (Blueprint $table) {
            $table->text('alasan_penolakan')->nullable()->after('status_izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_kehadiran', function (Blueprint $table) {
             $table->dropColumn('alasan_penolakan');
        });
    }
};

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
            $table->enum('status_izin', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->after('file_pendukung_izin');

            $table->foreignId('approved_by')->nullable()->constrained('users')->after('status_izin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_kehadiran', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status_izin', 'approved_by']);
        });
    }
};

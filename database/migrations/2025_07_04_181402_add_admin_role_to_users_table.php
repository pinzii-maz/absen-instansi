    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         $roles = [
            'admin', // Role baru untuk super admin
            'kepala_biro',
            'kepala_bagian_perencanaan_dan_kepegawaian',
            'kepala_bagian_protokol',
            'kepala_bagian_materi_dan_komunikasi_pimpinan',
            'kepala_sub_bagian_tata_usaha',
            'analisi_kebijakan_ahli_muda',
            'pranata_hubungan_masyarakat_ahli_muda',
            'pelaksana'
        ];

        // Menggunakan DB::statement untuk mengubah kolom ENUM yang sudah ada.
        // Ini adalah cara yang aman untuk memodifikasi tipe ENUM di MySQL.
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('" . implode("','", $roles) . "') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $roles = [
            'kepala_biro',
            'kepala_bagian_perencanaan_dan_kepegawaian',
            'kepala_bagian_protokol',
            'kepala_bagian_materi_dan_komunikasi_pimpinan',
            'kepala_sub_bagian_tata_usaha',
            'analisi_kebijakan_ahli_muda',
            'pranata_hubungan_masyarakat_ahli_muda',
            'pelaksana'
        ];
        DB::statement("ALTER TABLE users CHANGE COLUMN role role ENUM('" . implode("','", $roles) . "') NOT NULL");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Extend kolom `prodi` dari ENUM('R','A','AK') menjadi ENUM('R','A','AK','AB','AP')
     * pada tabel ajupengabdian dan ajuan_penelitian_models agar sinkron
     * dengan validator DosenController yang sudah menerima AB dan AP.
     */
    public function up(): void
    {
        $tables = ['ajupengabdian', 'ajuan_penelitian_models', 'kum_pengabdian_models', 'kum_penelitian_models'];

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE `{$table}` MODIFY COLUMN `prodi` ENUM('R','A','AK','AB','AP') NULL");
        }
    }

    public function down(): void
    {
        // Hati-hati: rollback akan gagal jika ada data dengan nilai 'AB' atau 'AP'
        $tables = ['ajupengabdian', 'ajuan_penelitian_models', 'kum_pengabdian_models', 'kum_penelitian_models'];

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE `{$table}` MODIFY COLUMN `prodi` ENUM('R','A','AK') NULL");
        }
    }
};

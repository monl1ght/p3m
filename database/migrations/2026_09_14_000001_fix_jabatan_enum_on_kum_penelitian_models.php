<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perbaiki enum jabatan di kum_penelitian_models.
     *
     * Database memiliki enum('DR','RK','KP','DS') — nilai 'RK' tidak konsisten
     * dengan semua tabel lain (kum_pengabdian_models, ajuan_penelitian_models,
     * ajupengabdian) yang menggunakan 'LT' (Wakil Direktur).
     *
     * Langkah:
     *  1. Ubah baris 'RK' → 'LT' terlebih dahulu (jika ada data historis).
     *  2. Modifikasi kolom ke enum yang benar.
     */
    public function up(): void
    {
        // Langkah 1: Migrasi data lama — ubah 'RK' menjadi 'LT' agar tidak
        // ada data yang hilang saat enum diperketat.
        DB::table('kum_penelitian_models')
            ->where('jabatan', 'RK')
            ->update(['jabatan' => 'LT']);

        // Langkah 2: Ubah kolom menjadi enum yang konsisten.
        DB::statement("ALTER TABLE kum_penelitian_models MODIFY jabatan ENUM('DR','LT','KP','DS') NULL");
    }

    /**
     * Kembalikan ke enum lama jika perlu rollback.
     */
    public function down(): void
    {
        // Kembalikan 'LT' → 'RK' sebelum mengubah enum.
        DB::table('kum_penelitian_models')
            ->where('jabatan', 'LT')
            ->update(['jabatan' => 'RK']);

        DB::statement("ALTER TABLE kum_penelitian_models MODIFY jabatan ENUM('DR','RK','KP','DS') NULL");
    }
};

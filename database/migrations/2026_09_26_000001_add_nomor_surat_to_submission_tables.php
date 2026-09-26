<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add `nomor_surat` column to `ajupengabdian` and `ajuan_penelitian_models`.
     */
    public function up(): void
    {
        $tables = ['ajupengabdian', 'ajuan_penelitian_models'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'nomor_surat')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->string('nomor_surat', 150)->nullable()->after('status');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['ajupengabdian', 'ajuan_penelitian_models'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'nomor_surat')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('nomor_surat');
                });
            }
        }
    }
};

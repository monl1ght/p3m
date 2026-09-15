<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perluas kolom biaya dari double(8,2) ke decimal(15,2).
     *
     * double(8,2) hanya menampung max 999999.99 — tidak cukup untuk biaya penelitian
     * yang lazimnya bernilai jutaan hingga ratusan juta rupiah.
     * decimal(15,2) menampung hingga 9,999,999,999,999.99 dengan presisi yang tepat.
     */
    public function up(): void
    {
        $tables = ['ajupengabdian', 'ajuan_penelitian_models', 'kum_pengabdian_models', 'kum_penelitian_models'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->decimal('biaya', 15, 2)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        $tables = ['ajupengabdian', 'ajuan_penelitian_models', 'kum_pengabdian_models', 'kum_penelitian_models'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->double('biaya', 8, 2)->nullable()->change();
            });
        }
    }
};

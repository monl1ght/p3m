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
        Schema::table('m__pengelolas', function (Blueprint $table) {
            if (!Schema::hasColumn('m__pengelolas', 'jenis_identitas')) {
                $table->string('jenis_identitas', 10)->default('NIDN')->after('nama_pengelola');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m__pengelolas', function (Blueprint $table) {
            if (Schema::hasColumn('m__pengelolas', 'jenis_identitas')) {
                $table->dropColumn('jenis_identitas');
            }
        });
    }
};

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
        if (Schema::hasTable('jurnal_models') && !Schema::hasColumn('jurnal_models', 'kategori')) {
            Schema::table('jurnal_models', function (Blueprint $table) {
                $table->string('kategori', 50)->nullable()->after('link');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('jurnal_models') && Schema::hasColumn('jurnal_models', 'kategori')) {
            Schema::table('jurnal_models', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }
    }
};

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
        Schema::table('anggotap3m_models', function (Blueprint $table) {
            //
            $table->foreignId('kpengab_model_id')->nullable()->constrained('kum_pengabdian_models')->onDelete('cascade');
            $table->foreignId('kpenel_model_id')->nullable()->constrained('kum_penelitian_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotap3m_models', function (Blueprint $table) {
            $table->dropForeign(['kpengab_model_id']);
            $table->dropForeign(['kpenel_model_id']);
            $table->dropColumn(['kpengab_model_id', 'kpenel_model_id']);
        });
    }
};

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


            $table->foreignId('ajupengab_model_id')->constrained('ajupengabdian')->onDelete('cascade');
            $table->foreignId('ajupenel_model_id')->constrained('ajuan_penelitian_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotap3m_models', function (Blueprint $table) {
            //
        });
    }
};

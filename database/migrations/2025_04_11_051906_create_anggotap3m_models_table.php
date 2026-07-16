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
        Schema::create('anggotap3m_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('p3m_model_id')->constrained('p3m_models')->onDelete('cascade');
            $table->string('nama');
            $table->string('prodi')->nullable();
            $table->string('jabatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotap3m_models');
    }
};

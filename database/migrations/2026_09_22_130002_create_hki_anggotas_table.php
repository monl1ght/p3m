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
        if (!Schema::hasTable('hki_anggotas')) {
            Schema::create('hki_anggotas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hki_id')->constrained('hkis')->cascadeOnDelete();
                $table->string('nama', 150);
                $table->string('nim_nidn', 50)->nullable();
                $table->string('peran', 50)->nullable()->default('Anggota')->comment('Pencipta Utama / Anggota Pencipta');
                $table->tinyInteger('urutan')->unsigned()->default(1)->comment('Urutan nama pencipta');
                $table->timestamps();

                $table->index('hki_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_anggotas');
    }
};

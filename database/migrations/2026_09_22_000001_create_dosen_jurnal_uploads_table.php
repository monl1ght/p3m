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
        if (!Schema::hasTable('dosen_jurnal_uploads')) {
            Schema::create('dosen_jurnal_uploads', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('judul');
                $table->string('kategori', 50);
                $table->string('file_path');
                $table->string('file_name');
                $table->enum('status', ['diproses', 'diterima', 'direvisi', 'ditolak'])->default('diproses');
                $table->text('catatan_admin')->nullable();
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_jurnal_uploads');
    }
};

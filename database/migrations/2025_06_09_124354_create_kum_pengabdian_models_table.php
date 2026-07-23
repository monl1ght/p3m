<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel kum_pengabdian_models.
     */
    public function up(): void
    {
        Schema::create('kum_pengabdian_models', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->string('bidang');
            $table->string('jeniskategori');
            $table->string('ketua');
            $table->enum('jeniskelamin', ['L', 'P']);

            $table->string('nidn')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('prodi')->nullable();
            $table->string('telp')->nullable();
            $table->text('alamat')->nullable();

            $table->string('lokasi')->nullable();
            $table->string('lamapenelitian')->nullable();

            // Decimal lebih aman untuk data nominal daripada float.
            $table->decimal('biaya', 15, 2)->nullable();

            $table->string('uppdf')->nullable();
            $table->string('foto')->nullable();

            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel kum_pengabdian_models.
     */
    public function down(): void
    {
        Schema::dropIfExists('kum_pengabdian_models');
    }
};
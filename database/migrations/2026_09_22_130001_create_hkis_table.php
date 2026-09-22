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
        if (!Schema::hasTable('hkis')) {
            Schema::create('hkis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('judul');
                $table->date('tanggal')->comment('Tanggal pencatatan/penerbitan sertifikat HKI');
                $table->string('jenis_hki', 100)->nullable()->comment('Hak Cipta, Paten, Merek, Desain Industri, dsb.');
                $table->string('nomor_pencatatan', 100)->nullable()->comment('Nomor registrasi resmi dari DJKI');
                $table->string('file_path')->comment('Path relatif di private disk');
                $table->string('file_name')->comment('Nama asli berkas yang diunggah dosen');
                $table->enum('status', ['diproses', 'diterima', 'direvisi', 'ditolak'])->default('diproses');
                $table->text('catatan_admin')->nullable()->comment('Catatan verifikasi/revisi dari admin');
                $table->timestamp('read_at')->nullable()->comment('Timestamp saat admin pertama kali melihat');
                $table->timestamps();

                $table->index('user_id');
                $table->index('status');
                $table->index('tanggal');
                $table->index('read_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hkis');
    }
};

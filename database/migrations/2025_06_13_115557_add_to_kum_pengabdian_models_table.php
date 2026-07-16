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
        Schema::table('kum_pengabdian_models', function (Blueprint $table) {
            //
            $table->string('judul')->after('id');
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
            $table->float('biaya')->nullable();

            $table->string('uppdf')->nullable(); // untuk file PDF
            $table->string('foto')->nullable(); // untuk foto

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kum_pengabdian_models', function (Blueprint $table) {
            //
        });
    }
};

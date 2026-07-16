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
        Schema::create('ajupengabdian', function (Blueprint $table) {

            $table->id();
            $table->string('judul');
            $table->string('bidang');
            $table->string('jeniskategori');
            $table->string('ketua');
            $table->enum('jeniskelamin', ['L', 'P']);
            $table->string('nidn')->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('prodi', ['R', 'A', 'AK'])->nullable();
            $table->string('telp')->nullable();
            $table->text('alamat')->nullable();

            $table->string('lokasi')->nullable();
            $table->string('lamapenelitian')->nullable();
            $table->float('biaya')->nullable();

            $table->string('uppdf')->nullable(); // untuk file PDF
            //user
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajupengabdian');
    }
};

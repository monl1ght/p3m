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
        Schema::table('kum_penelitian_models', function (Blueprint $table) {
            //
            $table->string('judul')->after('id');
            $table->string('bidang')->after('judul');
            $table->string('jeniskategori')->after('bidang');
            $table->string('ketua')->after('jeniskategori');
            $table->enum('jeniskelamin', ['L', 'P'])->after('ketua');
            $table->string('nidn')->nullable()->after('jeniskelamin');
            $table->string('jabatan')->nullable()->after('nidn');
            $table->string('prodi')->nullable()->after('jabatan');
            $table->string('telp')->nullable()->after('prodi');
            $table->text('alamat')->nullable()->after('telp');

            $table->string('lokasi')->nullable()->after('alamat');
            $table->string('lamapenelitian')->nullable()->after('lokasi');
            $table->float('biaya')->nullable()->after('lamapenelitian');

            $table->string('uppdf')->nullable()->after('biaya'); // untuk file PDF
            $table->string('foto')->nullable()->after('uppdf'); // untuk foto

            $table->unsignedBigInteger('user_id')->nullable()->after('foto');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kum_penelitian_models', function (Blueprint $table) {
            //
        });
    }
};

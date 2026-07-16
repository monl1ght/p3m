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
        Schema::create('m__pengelolas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengelola');
            $table->string('NIDN');
            $table->string('jabatan_pengelola');
            $table->string('email_pengelola')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m__pengelolas');
    }
};

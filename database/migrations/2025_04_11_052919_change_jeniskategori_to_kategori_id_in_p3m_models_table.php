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
        Schema::table('p3m_models', function (Blueprint $table) {
            // $table->dropColumn('jeniskategori'); // hapus kolom lama
            $table->foreignId('kategori_id')->nullable()->constrained('m_categories')->onDelete('set null'); // ganti jadi relasi

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('p3m_models', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
            // $table->string('jeniskategori')->nullable(); // restore kolom lama

        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan DEFAULT 'dosen' pada kolom role di tabel users.
     *
     * Ini diperlukan karena:
     * 1. 'role' dihapus dari $fillable (VUL-A fix) sehingga INSERT awal tidak menyertakan kolom ini.
     * 2. Tanpa DEFAULT, MySQL strict mode akan throw error 1364 pada INSERT tanpa kolom role.
     * 3. DEFAULT 'dosen' aman — role admin hanya bisa diset secara eksplisit di kode.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('dosen')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default(null)->change();
        });
    }
};

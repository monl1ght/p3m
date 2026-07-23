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
        foreach ($this->tables() as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->timestamp('read_at')->nullable()->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables() as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('read_at');
            });
        }
    }

    /**
     * Tables used by the notification read-state feature.
     *
     * @return array<int, string>
     */
    private function tables(): array
    {
        return [
            'ajupengabdian',
            'ajuan_penelitian_models',
            'kum_pengabdian_models',
            'kum_penelitian_models',
        ];
    }
};

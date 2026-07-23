<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // No-op: these columns and the user_id foreign key are owned by
        // 2025_06_09_124408_create_kum_penelitian_models_table.php.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No schema changes were made in up().
    }
};

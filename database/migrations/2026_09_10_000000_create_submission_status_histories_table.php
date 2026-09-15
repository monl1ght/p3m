<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_status_histories', function (Blueprint $table) {
            $table->id();
            $table->string('submission_type', 40);
            $table->unsignedBigInteger('submission_id');
            $table->string('previous_status', 20);
            $table->string('status', 20);
            $table->text('reason')->nullable();
            $table->foreignId('decided_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('decided_at');
            $table->timestamps();

            $table->index(['submission_type', 'submission_id']);
            $table->index('decided_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_status_histories');
    }
};

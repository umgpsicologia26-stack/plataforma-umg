<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('evaluation_attempts')) {
            return;
        }

        Schema::create('evaluation_attempts', function (Blueprint $table) {
            $table->char('uuid', 36)->primary();
            $table->char('evaluacion_uuid', 36);
            $table->char('user_uuid', 36);
            $table->string('status', 30)->default('EN_PROGRESO');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('evaluacion_uuid')
                ->references('uuid')->on('evaluaciones')
                ->cascadeOnDelete();

            $table->foreign('user_uuid')
                ->references('uuid')->on('users')
                ->cascadeOnDelete();

            $table->index(['user_uuid', 'status']);
        });
    }

    public function down(): void
    {
        // No eliminar intentos ni datos existentes.
    }
};
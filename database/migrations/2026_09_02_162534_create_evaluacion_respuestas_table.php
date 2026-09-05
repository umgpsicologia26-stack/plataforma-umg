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
        Schema::create('evaluacion_respuestas', function (Blueprint $table) {
            $table->char('uuid', 36)->primary();

            $table->char('evaluacion_uuid', 36);

            $table->char('pregunta_uuid', 36);

            $table->char('user_uuid', 36);

            $table->text('respuesta');

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->foreign('evaluacion_uuid')
                ->references('uuid')
                ->on('evaluaciones')
                ->cascadeOnDelete();

            $table->foreign('pregunta_uuid')
                ->references('uuid')
                ->on('evaluacion_preguntas')
                ->cascadeOnDelete();

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_respuestas');
    }
};
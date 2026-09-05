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
        Schema::create('evaluacion_preguntas', function (Blueprint $table) {
            $table->char('uuid', 36)->primary();

            $table->char('evaluacion_uuid', 36);

            $table->text('question');

            $table->string('question_type', 50)
                ->default('OPCION_MULTIPLE');

            $table->json('options')->nullable();

            $table->unsignedInteger('question_order')
                ->default(1);

            $table->boolean('required')
                ->default(true);

            $table->timestamps();

            $table->foreign('evaluacion_uuid')
                ->references('uuid')
                ->on('evaluaciones')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_preguntas');
    }
};
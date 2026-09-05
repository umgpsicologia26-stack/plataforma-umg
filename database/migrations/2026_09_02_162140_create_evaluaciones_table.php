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
        Schema::create('evaluaciones', function (Blueprint $table) {

            $table->char('uuid', 36)->primary();

            $table->string('title', 200);

            $table->text('description')->nullable();

            $table->enum('status', [
                'ACTIVA',
                'INACTIVA'
            ])->default('ACTIVA');

            $table->char('created_by', 36)->nullable();

            $table->timestamps();

            $table->foreign('created_by')
                ->references('uuid')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
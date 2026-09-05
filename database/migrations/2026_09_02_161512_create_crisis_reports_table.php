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
        Schema::create('crisis_reports', function (Blueprint $table) {

            $table->char('uuid', 36)->primary();

            $table->char('user_uuid', 36);

            $table->string('report_type');

            $table->text('description')->nullable();

            $table->string('emergency_level');

            $table->string('status')->default('PENDIENTE');

            $table->char('assigned_to', 36)->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('crisis_reports');
    }
};
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
        Schema::create('mensajes_foro', function (Blueprint $table) {

            $table->char('uuid', 36)->primary();

            $table->char('user_uuid', 36);

            $table->string('category')->default('GENERAL');

            $table->text('content');

            $table->boolean('is_anonymous')->default(false);

            $table->boolean('ai_flagged')->default(false);

            $table->string('visibility_status')->default('VISIBLE');

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
        Schema::dropIfExists('mensajes_foro');
    }
};
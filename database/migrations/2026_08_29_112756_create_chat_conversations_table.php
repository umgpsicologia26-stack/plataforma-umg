<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_conversations', function (Blueprint $table) {

            $table->id();

            // Identificador público de la conversación
            $table->uuid('uuid')->unique();

            // Usuario que inició la conversación
            $table->char('user_uuid', 36);

            // Moderador asignado
            $table->char('moderator_uuid', 36)
                ->nullable();

            // Estado de la conversación
            $table->enum('status', [
                'ESPERANDO',
                'ACTIVO',
                'CERRADO'
            ])->default('ESPERANDO');

            $table->timestamps();

            // Relación con users.uuid
            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();

            // Si se elimina el moderador, la conversación permanece
            $table->foreign('moderator_uuid')
                ->references('uuid')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};

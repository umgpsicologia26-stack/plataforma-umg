<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {

            $table->id();

            // Identificador único del mensaje
            $table->uuid('uuid')->unique();

            // Conversación a la que pertenece
            $table->foreignId('conversation_id')
                ->constrained('chat_conversations')
                ->cascadeOnDelete();

            // Usuario que envió el mensaje
            $table->char('sender_uuid', 36)
                ->charset('utf8mb4')
                ->collation('utf8mb4_0900_ai_ci');

            // USER, MODERATOR o BOT
            $table->enum('sender_type', [
                'USER',
                'MODERATOR',
                'BOT'
            ]);

            // Contenido del mensaje
            $table->text('message');

            $table->timestamps();

            // Relación con users.uuid
            $table->foreign('sender_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
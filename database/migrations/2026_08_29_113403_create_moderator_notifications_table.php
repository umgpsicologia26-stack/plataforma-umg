<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderator_notifications', function (Blueprint $table) {

            $table->id();

            // Moderador que recibe la notificación
            $table->char('moderator_uuid', 36)
                ->charset('utf8mb4')
                ->collation('utf8mb4_0900_ai_ci');

            // Conversación relacionada
            $table->foreignId('conversation_id')
                ->constrained('chat_conversations')
                ->cascadeOnDelete();

            // Texto de la notificación
            $table->string('message');

            // Si ya fue revisada
            $table->boolean('read')->default(false);

            $table->timestamps();

            // Relación con users.uuid
            $table->foreign('moderator_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderator_notifications');
    }
};
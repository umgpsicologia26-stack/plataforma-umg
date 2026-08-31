<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar migración.
     */
    public function up(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {

            $table->timestamp('moderator_last_read_at')
                ->nullable()
                ->after('status');

        });
    }

    /**
     * Revertir migración.
     */
    public function down(): void
    {
        Schema::table('chat_conversations', function (Blueprint $table) {

            $table->dropColumn('moderator_last_read_at');

        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            // Los mensajes BOT no pertenecen a un registro de users.
            // La clave foránea se conserva; NULL representa al remitente del sistema.
            $table->char('sender_uuid', 36)->nullable()->change();
        });
    }

    public function down(): void
    {
        // No atribuir mensajes del BOT a un usuario para poder revertir el esquema.
        if (DB::table('chat_messages')->whereNull('sender_uuid')->exists()) {
            throw new RuntimeException(
                'No se puede revertir esta migración mientras existan mensajes sin sender_uuid. '
                . 'Respalda o gestiona esos mensajes antes de volver a NOT NULL.'
            );
        }

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->char('sender_uuid', 36)->nullable(false)->change();
        });
    }
};

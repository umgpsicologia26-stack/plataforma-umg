<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('moderator_notifications', 'evaluacion_uuid')) {
            Schema::table('moderator_notifications', function (Blueprint $table) {
                $table->char('evaluacion_uuid', 36)->nullable()->after('conversation_id');
            });
        }

        if (!Schema::hasColumn('moderator_notifications', 'attempt_uuid')) {
            Schema::table('moderator_notifications', function (Blueprint $table) {
                $table->char('attempt_uuid', 36)->nullable()->after('evaluacion_uuid');
            });
        }

        $column = DB::selectOne("
            SELECT IS_NULLABLE
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'moderator_notifications'
              AND COLUMN_NAME = 'conversation_id'
        ");

        if ($column && $column->IS_NULLABLE === 'NO') {
            Schema::table('moderator_notifications', function (Blueprint $table) {
                $table->foreignId('conversation_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // No eliminar estructuras existentes.
    }
};
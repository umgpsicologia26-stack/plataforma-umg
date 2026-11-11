<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('evaluacion_respuestas', 'attempt_uuid')) {
            Schema::table('evaluacion_respuestas', function (Blueprint $table) {
                $table->char('attempt_uuid', 36)->nullable()->after('uuid');
            });
        }

        $index = DB::select("
            SHOW INDEX FROM evaluacion_respuestas
            WHERE Key_name = 'evaluacion_respuestas_attempt_uuid_index'
        ");

        if (!$index) {
            Schema::table('evaluacion_respuestas', function (Blueprint $table) {
                $table->index('attempt_uuid');
            });
        }

        $foreignKey = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'evaluacion_respuestas'
              AND COLUMN_NAME = 'attempt_uuid'
              AND REFERENCED_TABLE_NAME = 'evaluation_attempts'
        ");

        if (!$foreignKey) {
            Schema::table('evaluacion_respuestas', function (Blueprint $table) {
                $table->foreign('attempt_uuid')
                    ->references('uuid')
                    ->on('evaluation_attempts')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // No eliminar relaciones ni datos existentes.
    }
};
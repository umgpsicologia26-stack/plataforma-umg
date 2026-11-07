
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * 1. Crear evaluation_attempts solamente si no existe.
         */
        if (!Schema::hasTable('evaluation_attempts')) {
            Schema::create('evaluation_attempts', function (Blueprint $table) {
                $table->char('uuid', 36)->primary();

                $table->char('evaluacion_uuid', 36);
                $table->char('user_uuid', 36);

                $table->enum('status', [
                    'EN_PROCESO',
                    'COMPLETADA',
                    'ABANDONADA',
                ])->default('EN_PROCESO');

                $table->timestamp('started_at')->nullable()->useCurrent();
                $table->timestamp('completed_at')->nullable();

                $table->timestamps();

                $table->unique(
                    ['evaluacion_uuid', 'user_uuid'],
                    'evaluation_attempts_one_per_user'
                );

                $table->foreign('evaluacion_uuid')
                    ->references('uuid')
                    ->on('evaluaciones')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();

                $table->foreign('user_uuid')
                    ->references('uuid')
                    ->on('users')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }

        /*
         * 2. Agregar attempt_uuid a las respuestas
         * solamente si todavía no existe.
         */
        if (!Schema::hasColumn('evaluacion_respuestas', 'attempt_uuid')) {
            Schema::table('evaluacion_respuestas', function (Blueprint $table) {
                $table->char('attempt_uuid', 36)->nullable();

                $table->foreign('attempt_uuid')
                    ->references('uuid')
                    ->on('evaluation_attempts')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }

        /*
         * 3. Permitir conversation_id NULL.
         * Solo modificarlo si actualmente es NOT NULL.
         */
        $conversationColumn = DB::selectOne(
            "SELECT IS_NULLABLE
             FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
             AND TABLE_NAME = ?
             AND COLUMN_NAME = ?",
            ['moderator_notifications', 'conversation_id']
        );

        if ($conversationColumn && $conversationColumn->IS_NULLABLE === 'NO') {
            Schema::table('moderator_notifications', function (Blueprint $table) {
                $table->unsignedBigInteger('conversation_id')
                    ->nullable()
                    ->change();
            });
        }

        /*
         * 4. Agregar los campos de evaluación
         * únicamente cuando no existan.
         */
        if (!Schema::hasColumn('moderator_notifications', 'evaluacion_uuid')) {
            Schema::table('moderator_notifications', function (Blueprint $table) {
                $table->char('evaluacion_uuid', 36)->nullable();

                $table->foreign('evaluacion_uuid')
                    ->references('uuid')
                    ->on('evaluaciones')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }

        if (!Schema::hasColumn('moderator_notifications', 'attempt_uuid')) {
            Schema::table('moderator_notifications', function (Blueprint $table) {
                $table->char('attempt_uuid', 36)->nullable();

                $table->foreign('attempt_uuid')
                    ->references('uuid')
                    ->on('evaluation_attempts')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }
    }

    public function down(): void
    {
        /*
         * No eliminar estructuras durante un rollback.
         * Algunas pueden existir previamente y contener datos
         * utilizados por la plataforma.
         */
    }
};
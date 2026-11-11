<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('evaluation_attempts')
            || !Schema::hasTable('evaluaciones')
            || !Schema::hasTable('moderator_notifications')) {
            throw new RuntimeException(
                'Faltan tablas necesarias para completar las relaciones de evaluaciones.'
            );
        }

        // Verificar que no existan intentos repetidos.
        $duplicados = DB::select("
            SELECT evaluacion_uuid, user_uuid, COUNT(*) AS total
            FROM evaluation_attempts
            GROUP BY evaluacion_uuid, user_uuid
            HAVING COUNT(*) > 1
        ");

        if ($duplicados) {
            throw new RuntimeException(
                'Existen intentos duplicados. No se puede crear el índice único.'
            );
        }

        // Crear índice único si todavía no existe.
        $indice = DB::select("
            SHOW INDEX FROM evaluation_attempts
            WHERE Key_name = 'evaluation_attempts_one_per_user'
        ");

        if (!$indice) {
            DB::statement("
                ALTER TABLE evaluation_attempts
                ADD UNIQUE INDEX evaluation_attempts_one_per_user
                (evaluacion_uuid, user_uuid)
            ");
        }

        // Comprobar referencias de evaluaciones.
        $evaluacionesHuerfanas = DB::table('moderator_notifications as mn')
            ->leftJoin('evaluaciones as e', 'e.uuid', '=', 'mn.evaluacion_uuid')
            ->whereNotNull('mn.evaluacion_uuid')
            ->whereNull('e.uuid')
            ->exists();

        if ($evaluacionesHuerfanas) {
            throw new RuntimeException(
                'Hay notificaciones con evaluacion_uuid sin evaluación relacionada.'
            );
        }

        // Comprobar referencias de intentos.
        $intentosHuerfanos = DB::table('moderator_notifications as mn')
            ->leftJoin('evaluation_attempts as ea', 'ea.uuid', '=', 'mn.attempt_uuid')
            ->whereNotNull('mn.attempt_uuid')
            ->whereNull('ea.uuid')
            ->exists();

        if ($intentosHuerfanos) {
            throw new RuntimeException(
                'Hay notificaciones con attempt_uuid sin intento relacionado.'
            );
        }

        // Agregar claves foráneas únicamente si faltan.
        $this->addForeignKey(
            'moderator_notifications',
            'moderator_notifications_evaluacion_uuid_foreign',
            'evaluacion_uuid',
            'evaluaciones',
            'uuid',
            'SET NULL'
        );

        $this->addForeignKey(
            'moderator_notifications',
            'moderator_notifications_attempt_uuid_foreign',
            'attempt_uuid',
            'evaluation_attempts',
            'uuid',
            'SET NULL'
        );
    }

    private function addForeignKey(
        string $table,
        string $constraint,
        string $column,
        string $referencedTable,
        string $referencedColumn,
        string $onDelete
    ): void {
        $exists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.REFERENTIAL_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND CONSTRAINT_NAME = ?
        ", [$table, $constraint]);

        if ($exists) {
            return;
        }

        DB::statement("
            ALTER TABLE `{$table}`
            ADD CONSTRAINT `{$constraint}`
            FOREIGN KEY (`{$column}`)
            REFERENCES `{$referencedTable}` (`{$referencedColumn}`)
            ON DELETE {$onDelete}
        ");
    }

    public function down(): void
    {
        // No eliminar restricciones ni índices para proteger datos existentes.
    }
};

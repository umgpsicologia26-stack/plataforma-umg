<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            // Eliminar la relación anterior hacia users
            $table->dropForeign('fk_audit_logs_target_user');

            // Eliminar el campo que solo permitía auditar usuarios
            $table->dropColumn('target_user');

            // Nuevo objetivo de auditoría
            $table->string('target_type', 100)->after('performed_by');
            $table->string('target_id', 36)->after('target_type');

            // Índice para búsquedas de auditoría
            $table->index(
                ['target_type', 'target_id'],
                'idx_audit_logs_target'
            );
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropIndex('idx_audit_logs_target');

            $table->dropColumn([
                'target_type',
                'target_id'
            ]);

            $table->char('target_user', 36)
                ->after('performed_by');

            $table->foreign(
                'target_user',
                'fk_audit_logs_target_user'
            )
                ->references('uuid')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }
};
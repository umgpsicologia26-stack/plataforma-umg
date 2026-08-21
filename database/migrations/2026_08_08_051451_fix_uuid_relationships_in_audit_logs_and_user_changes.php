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
        |--------------------------------------------------------------------------
        | AUDIT LOGS
        |--------------------------------------------------------------------------
        | Primero eliminamos las claves foráneas para poder modificar
        | las columnas UUID.
        */

        Schema::table('audit_logs', function (Blueprint $table) {

            $table->dropForeign('fk_audit_logs_performed_by');
            $table->dropForeign('fk_audit_logs_target_user');

        });


        //UUID PERFORMED_BY
        DB::statement("
            ALTER TABLE audit_logs
            MODIFY performed_by CHAR(36)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_0900_ai_ci
            NOT NULL
        ");

        //UUID TARGET_USER
        DB::statement("
            ALTER TABLE audit_logs
            MODIFY target_user CHAR(36)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_0900_ai_ci
            NOT NULL
        ");


        //VOLVER A CREAR RELACIONES
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->foreign(
                'performed_by',
                'fk_audit_logs_performed_by'
            )
            ->references('uuid')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');

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

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropForeign(
                'fk_audit_logs_performed_by'
            );

            $table->dropForeign(
                'fk_audit_logs_target_user'
            );
        });
    }
};
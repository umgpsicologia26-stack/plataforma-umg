<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Corrige las relaciones UUID de case_files.
    public function up(): void
    {
        Schema::table('case_files', function (Blueprint $table) {

            // Eliminar las referencias antiguas basadas en ID
            $table->dropColumn([
                'user_id',
                'moderator_id',
            ]);
        });
        Schema::table('case_files', function (Blueprint $table) {

            // Relación con el usuario propietario del caso
            $table->foreign('user_uuid', 'fk_case_files_user_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            // Relación con el moderador que gestiona el caso
            $table->foreign('moderator_uuid', 'fk_case_files_moderator_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    // Revierte las modificaciones.
    public function down(): void
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->dropForeign('fk_case_files_user_uuid');
            $table->dropForeign('fk_case_files_moderator_uuid');
        });
        Schema::table('case_files', function (Blueprint $table) {

            // Restaurar las columnas antiguas
            $table->unsignedBigInteger('user_id')
                ->nullable();
            $table->unsignedBigInteger('moderator_id')
                ->nullable();
        });
    }
};
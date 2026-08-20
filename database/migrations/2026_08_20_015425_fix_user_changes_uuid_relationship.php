<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | user_changes ya fue corregida
        |--------------------------------------------------------------------------
        |
        | La columna user_uuid ya existe como CHAR(36), utiliza la misma
        | configuración que users.uuid y posee la FK:
        |
        | fk_user_changes_user_uuid
        |
        | Por lo tanto, no realizamos modificaciones adicionales.
        |
        */
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | No revertir.
        |--------------------------------------------------------------------------
        |
        | La estructura actual utiliza UUID como relación con users.
        |
        */
    }
};
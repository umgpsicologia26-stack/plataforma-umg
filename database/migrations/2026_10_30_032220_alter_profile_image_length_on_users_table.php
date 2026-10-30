<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `users`
            MODIFY `profile_image`
            VARCHAR(2048)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NULL DEFAULT NULL
        ");
    }

    public function down(): void
    {
        $hasLongUrls = DB::table('users')
            ->whereRaw('CHAR_LENGTH(profile_image) > 255')
            ->exists();

        if ($hasLongUrls) {
            throw new \RuntimeException(
                'No se puede revertir: existen URLs de perfil mayores a 255 caracteres.'
            );
        }

        DB::statement("
            ALTER TABLE `users`
            MODIFY `profile_image`
            VARCHAR(255)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NULL DEFAULT NULL
        ");
    }
};

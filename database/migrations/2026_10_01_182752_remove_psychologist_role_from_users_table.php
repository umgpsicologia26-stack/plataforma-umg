<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('USER', 'MODERATOR', 'ADMIN')
            NOT NULL DEFAULT 'USER'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('USER', 'MODERATOR', 'ADMIN', 'PSYCHOLOGIST')
            NOT NULL DEFAULT 'USER'
        ");
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->char('user_uuid',36)
                ->nullable()
                ->after('description');
            $table->char('moderator_uuid',36)
                ->nullable()
                ->after('user_uuid');
        });
    }

    public function down(): void
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->dropColumn([
                'user_uuid',
                'moderator_uuid'
            ]);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_notifications', function (Blueprint $table) {

            $table->uuid('moderator_uuid')
                ->nullable()
                ->after('user_uuid');

            $table->foreign('moderator_uuid')
                ->references('uuid')
                ->on('users')
                ->nullOnDelete();

            $table->index([
                'moderator_uuid',
                'read_at'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('case_notifications', function (Blueprint $table) {

            $table->dropForeign([
                'moderator_uuid'
            ]);

            $table->dropIndex([
                'moderator_uuid',
                'read_at'
            ]);

            $table->dropColumn('moderator_uuid');
        });
    }
};
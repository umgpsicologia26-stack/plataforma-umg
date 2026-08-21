<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_notifications', function (Blueprint $table) {

            $table->unsignedBigInteger('case_id')
                ->nullable()
                ->after('id');

            $table->char('user_uuid', 36)
                ->nullable()
                ->after('case_id');
        });

        //Igualar UUID con users.uuid
        DB::statement("
            ALTER TABLE admin_notifications
            MODIFY user_uuid CHAR(36)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_0900_ai_ci
            NULL
        ");
        Schema::table('admin_notifications', function (Blueprint $table) {

            $table->foreign(
                'case_id',
                'fk_admin_notifications_case'
            )
            ->references('id')
            ->on('case_files')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign(
                'user_uuid',
                'fk_admin_notifications_user'
            )
            ->references('uuid')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('admin_notifications', function (Blueprint $table) {
            $table->dropForeign(
                'fk_admin_notifications_case'
            );

            $table->dropForeign(
                'fk_admin_notifications_user'
            );

            $table->dropColumn([
                'case_id',
                'user_uuid'
            ]);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nickname_history', function (Blueprint $table) {
            $table->char('uuid', 36)->primary();

            $table->char('user_uuid', 36);

            $table->string('old_nickname', 80)->nullable();

            $table->string('new_nickname', 80)->nullable();

            $table->timestamp('changed_at')->useCurrent();

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nickname_history');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_notifications', function (Blueprint $table) {

            $table->id();

            $table->uuid('user_uuid');

            $table->unsignedBigInteger('case_id');

            $table->unsignedBigInteger('comment_id')->nullable();

            $table->string('message');

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->foreign('user_uuid')
                ->references('uuid')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('case_id')
                ->references('id')
                ->on('case_files')
                ->cascadeOnDelete();

            $table->foreign('comment_id')
                ->references('id')
                ->on('case_comments')
                ->nullOnDelete();

            $table->index([
                'user_uuid',
                'read_at'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_notifications');
    }
};
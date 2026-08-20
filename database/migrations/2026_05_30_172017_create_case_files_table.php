<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_files', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->string('type');
            $table->text('description');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('moderator_id')->nullable();
            $table->string('status')->default('En seguimiento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_files');
    }
};
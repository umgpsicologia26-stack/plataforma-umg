<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('user_changes', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('field_changed');
        $table->text('old_value')->nullable();
        $table->text('new_value')->nullable();
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('user_changes');
    }
};
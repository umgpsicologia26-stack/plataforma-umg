<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('system_settings', function (Blueprint $table) {

        $table->id();

        $table->string('system_name')
            ->default('UMG');

        $table->boolean('forum_enabled')
            ->default(true);

        $table->boolean('panic_enabled')
        ->default(true);

        $table->boolean('registration_enabled')
            ->default(true);

        $table->timestamps();
    });
}

};
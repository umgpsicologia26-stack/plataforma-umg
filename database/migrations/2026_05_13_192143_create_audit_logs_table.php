<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();

        $table->string('action'); // update, delete, create
        $table->unsignedBigInteger('performed_by'); // admin/moderator
        $table->unsignedBigInteger('target_user'); // usuario afectado

        $table->text('changes')->nullable(); // JSON de cambios

        $table->timestamps();
    });
}
};

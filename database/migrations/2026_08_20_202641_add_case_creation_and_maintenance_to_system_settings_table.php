<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {

            $table->boolean('case_creation_enabled')
                ->default(true);

            $table->boolean('maintenance_mode')
                ->default(false);

        });
    }

    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {

            $table->dropColumn([
                'case_creation_enabled',
                'maintenance_mode'
            ]);

        });
    }
};
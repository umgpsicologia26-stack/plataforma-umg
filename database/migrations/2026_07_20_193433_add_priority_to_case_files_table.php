<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->enum(
                'priority',
                [
                    'Baja',
                    'Media',
                    'Alta',
                    'Critica'
                ]
            )->default('Media')
            ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('case_files', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};
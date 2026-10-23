
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderator_assignment_state', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->string('last_moderator_uuid', 36)->nullable();
            $table->timestamps();
        });

        // Un único registro global para controlar el turno.
        DB::table('moderator_assignment_state')->insert([
            'id' => 1,
            'last_moderator_uuid' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('moderator_assignment_state');
    }
};

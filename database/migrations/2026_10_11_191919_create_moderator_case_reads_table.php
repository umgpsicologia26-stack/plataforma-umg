
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moderator_case_reads', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('case_id');
            $table->char('moderator_uuid', 36);
            $table->timestamp('last_read_at')->nullable();

            $table->timestamps();

            $table->unique(
                ['case_id', 'moderator_uuid'],
                'moderator_case_reads_unique'
            );

            $table->index(
                'moderator_uuid',
                'moderator_case_reads_moderator_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moderator_case_reads');
    }
};

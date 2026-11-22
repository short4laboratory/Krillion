<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dives', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('player_name', 24);
            $table->json('question_ids');
            $table->unsignedSmallInteger('total_score')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['completed_at', 'total_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dives');
    }
};

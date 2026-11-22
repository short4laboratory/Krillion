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
        Schema::create('dive_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('dive_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('position');
            $table->string('answer', 60);
            $table->string('answer_key');
            $table->unsignedTinyInteger('points');
            $table->float('share');
            $table->string('fish_class');
            $table->timestamps();

            $table->unique(['dive_id', 'position']);
            $table->index(['question_id', 'answer_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dive_answers');
    }
};

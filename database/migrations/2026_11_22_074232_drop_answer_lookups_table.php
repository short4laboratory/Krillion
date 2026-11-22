<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Live per-answer lookups are no longer needed: every accepted answer's popularity is fetched ahead of time.
 * Rolling back recreates the table empty.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('answer_lookups');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('answer_lookups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->string('term');
            $table->unsignedInteger('encyclopedia_hits');
            $table->float('dictionary_frequency');
            $table->boolean('in_dictionary');
            $table->boolean('is_known');
            $table->float('weight');
            $table->timestamps();

            $table->unique(['question_id', 'key']);
        });
    }
};

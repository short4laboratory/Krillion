<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Link each answer to the answer-key entry it matched, and keep the Wikipedia page views it was scored on.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dive_answers', function (Blueprint $table) {
            $table->foreignId('accepted_answer_id')->nullable()->after('question_id')->constrained()->nullOnDelete();
            $table->unsignedInteger('pageviews')->nullable()->after('points');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dive_answers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('accepted_answer_id');
            $table->dropColumn('pageviews');
        });
    }
};

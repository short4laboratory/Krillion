<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Per-question countdown: dives remember when the current question was first shown,
 * and an answer can be a "miss" (time ran out) with no text at all.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dives', function (Blueprint $table) {
            $table->timestamp('question_started_at')->nullable()->after('total_score');
        });

        Schema::table('dive_answers', function (Blueprint $table) {
            $table->string('answer', 60)->nullable()->change();
            $table->string('answer_key')->nullable()->change();
            $table->boolean('timed_out')->default(false)->after('fish_class');
        });
    }

    /**
     * Reverse the migrations. Missed answers are given empty text so the columns can be required again.
     */
    public function down(): void
    {
        Schema::table('dives', function (Blueprint $table) {
            $table->dropColumn('question_started_at');
        });

        DB::table('dive_answers')->whereNull('answer')->update(['answer' => '', 'answer_key' => '']);

        Schema::table('dive_answers', function (Blueprint $table) {
            $table->dropColumn('timed_out');
            $table->string('answer', 60)->nullable(false)->change();
            $table->string('answer_key')->nullable(false)->change();
        });
    }
};

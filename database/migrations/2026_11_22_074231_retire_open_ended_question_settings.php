<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Open-ended questions ("name a fruit") are replaced by answer-key questions. Old questions are
 * retired rather than deleted so finished dives can still show their results.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['search_template', 'allows_invented_answers']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('article_suffix')->nullable()->after('placeholder');
            $table->timestamp('retired_at')->nullable()->after('article_suffix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['article_suffix', 'retired_at']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('search_template')->default('"{answer}"');
            $table->boolean('allows_invented_answers')->default(false);
        });
    }
};

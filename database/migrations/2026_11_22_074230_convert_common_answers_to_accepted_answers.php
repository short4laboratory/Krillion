<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Questions now have answer keys: every accepted answer is listed, along with how often
 * people look it up on Wikipedia (its popularity), fetched by `krillion:fetch-popularity`.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('common_answers', 'accepted_answers');

        Schema::table('accepted_answers', function (Blueprint $table) {
            $table->string('article')->nullable()->after('label');
            $table->string('resolved_article')->nullable()->after('article');
            $table->unsignedInteger('pageviews')->nullable()->after('resolved_article');
            $table->float('dictionary_frequency')->nullable()->after('pageviews');
            $table->float('weight')->nullable()->after('dictionary_frequency');
            $table->timestamp('popularity_fetched_at')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accepted_answers', function (Blueprint $table) {
            $table->dropColumn(['article', 'resolved_article', 'pageviews', 'dictionary_frequency', 'weight', 'popularity_fetched_at']);
        });

        Schema::rename('accepted_answers', 'common_answers');
    }
};

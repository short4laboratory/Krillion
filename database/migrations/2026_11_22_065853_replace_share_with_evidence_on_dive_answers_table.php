<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Store the evidence behind each score (encyclopedia mentions and earlier divers)
 * instead of an estimated population share.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dive_answers', function (Blueprint $table) {
            $table->dropColumn('share');
        });

        Schema::table('dive_answers', function (Blueprint $table) {
            $table->unsignedInteger('encyclopedia_hits')->nullable()->after('points');
            $table->unsignedInteger('prior_divers')->default(0)->after('encyclopedia_hits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dive_answers', function (Blueprint $table) {
            $table->dropColumn(['encyclopedia_hits', 'prior_divers']);
        });

        Schema::table('dive_answers', function (Blueprint $table) {
            $table->float('share')->default(0);
        });
    }
};

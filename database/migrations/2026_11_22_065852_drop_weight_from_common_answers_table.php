<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Hand-estimated weights are replaced by reference weights in answer_lookups.
 * Rolling back restores the column empty; the old estimates are not recoverable.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('common_answers', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('common_answers', function (Blueprint $table) {
            $table->unsignedInteger('weight')->default(0);
        });
    }
};

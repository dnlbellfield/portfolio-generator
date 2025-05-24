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
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['linkedin_url', 'github_url', 'twitter_url']);
            // Drop other fixed URL columns if you had more
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            // Add them back in case of rollback
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('twitter_url')->nullable();
            // Add back other columns you dropped
        });
    }
};

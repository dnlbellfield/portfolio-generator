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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job_title')->nullable(); // Making title optional
            $table->text('landing_page_summary')->nullable(); // Optional summary
            $table->string('about_me_heading')->nullable();
            $table->text('about_me_content')->nullable();
            $table->string('contact_heading')->nullable();
            $table->string('email')->nullable(); // Making email optional, though usually required for contact
            $table->string('portfolio_title')->nullable(); // Browser tab title
            $table->string('theme_basic')->nullable();
            $table->string('font_basic')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('profile_picture_url')->nullable(); // Optional profile picture
            $table->string('about_image_url')->nullable(); // Optional second about image
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};


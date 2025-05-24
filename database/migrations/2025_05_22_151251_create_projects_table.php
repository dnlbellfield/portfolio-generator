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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade'); // Link to portfolio
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable(); // Optional project image
            $table->string('live_demo_url')->nullable();
            $table->string('github_url')->nullable();
            $table->text('technologies')->nullable(); // Storing as text for now, could be a separate table later
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
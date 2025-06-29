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
        Schema::create('custom_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade'); // Link to portfolio
            $table->string('title');
            $table->integer('order')->default(0); // Optional: for ordering custom sections
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_sections');
    }
};
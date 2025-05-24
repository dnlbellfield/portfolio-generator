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
        Schema::create('custom_section_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_section_id')->constrained()->onDelete('cascade'); // Link to custom section
            $table->string('block_type'); // e.g., 'header', 'paragraph', 'image'
            $table->text('content')->nullable(); // Text content or image URL
            $table->integer('order')->default(0); // Optional: for ordering blocks within a section
            // Add other specific fields if needed per block type later (e.g., image alt text)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_section_blocks');
    }
};

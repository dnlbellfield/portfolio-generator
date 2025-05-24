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
            $table->string('skills_heading')->nullable()->after('font_basic'); // Add skills_heading, nullable, and after font_basic (adjust placement as desired)
            $table->text('skills_list')->nullable()->after('skills_heading'); // Add skills_list, nullable, and after skills_heading
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['skills_heading', 'skills_list']);
        });
    }
};

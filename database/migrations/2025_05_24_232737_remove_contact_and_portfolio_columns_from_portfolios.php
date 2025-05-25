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
        Schema::table('portfolios', function (Blueprint $table) { // Use 'portfolios' here
            // Make sure these column names match exactly what was created in the create_portfolios_table migration
            $table->dropColumn('contact_heading');
            $table->dropColumn('portfolio_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) { // Use 'portfolios' here
            // Add the columns back with the same data type and constraints as in the create_portfolios_table migration
            $table->string('contact_heading')->nullable(); // Adjust data type and constraints as needed
            $table->string('portfolio_title')->nullable();   // Adjust data type and constraints as needed
        });
    }
};

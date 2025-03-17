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
        Schema::table('contributions', function (Blueprint $table) {
            // Add the published_date column
            $table->date('published_date')->nullable()->after('submitted_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            // Drop the published_date column if the migration is rolled back
            $table->dropColumn('published_date');
        });
    }
};

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
        Schema::create('intakes', function (Blueprint $table) {
            $table->id('intake_id')->primary();
            $table->string('intake', 50);
            $table->unsignedBigInteger('academic_year_id'); // Foreign key to academic_years
            $table->date('closure_date')->nullable();
            $table->date('final_closure_date')->nullable();
            $table->string('status', 10)->default('active');
            $table->timestamps();

            // Define foreign key relationship
            $table->foreign('academic_year_id')->references('academic_year_id')->on('academic_years')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intakes');
    }
};

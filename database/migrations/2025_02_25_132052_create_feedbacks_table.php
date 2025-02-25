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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedback_id')->primary();
            $table->unsignedBigInteger('contribution_id'); // Foreign key to contributions
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->string('feedback', 255);
            $table->timestamp('feedback_given_date')->useCurrent();
            $table->timestamps();

            // Define foreign key relationships
            $table->foreign('contribution_id')->references('contribution_id')->on('contributions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};

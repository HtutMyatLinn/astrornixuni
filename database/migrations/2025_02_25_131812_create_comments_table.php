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
        Schema::create('comments', function (Blueprint $table) {
            $table->id('comment_id')->primary();
            $table->unsignedBigInteger('user_id'); // Foreign key to users
            $table->unsignedBigInteger('contribution_id'); // Foreign key to contributions
            $table->string('comment_text', 255);
            $table->timestamp('comment_date')->useCurrent();
            $table->timestamps();

            // Define foreign key relationships
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('contribution_id')->references('contribution_id')->on('contributions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

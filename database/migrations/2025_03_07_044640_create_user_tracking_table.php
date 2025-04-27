<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('browser_id'); // Foreign key to browser_stats table
            $table->unsignedBigInteger('user_id');   // Foreign key to users table
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('browser_id')->references('browser_id')->on('browser_stats')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tracking');
    }
};

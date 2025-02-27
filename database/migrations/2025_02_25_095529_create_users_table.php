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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id')->primary();
            $table->string('user_code', 7)->unique();
            $table->string('username', 30);
            $table->string('first_name', 30);
            $table->string('last_name', 30)->nullable();
            $table->string('email', 30)->unique();
            $table->string('password', 255);
            $table->string('profile_image', 255)->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->date('last_login_date')->nullable();
            $table->date('last_password_changed_date')->nullable();
            $table->date('password_expired_date')->nullable();
            $table->integer('login_count')->default(0);
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->foreign('faculty_id')->references('faculty_id')->on('faculties')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

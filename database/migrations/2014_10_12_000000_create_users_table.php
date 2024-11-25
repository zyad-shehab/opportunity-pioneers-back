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

        // Create countries table
        Schema::create('countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('code', 2)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('phone')->uniqid();
            $table->string('bio_ar')->nullable();
            $table->string('bio_en')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('type');
            $table->enum('status', ['active', 'inactive', 'suspended)'])->default('inactive');
            $table->integer('email_verified_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('phone_verified_code')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->uuid('country_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('users');
    }
};

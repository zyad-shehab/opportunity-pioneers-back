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
        Schema::create('jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('job_type');
            $table->decimal('salary', 8, 2)->nullable();
            $table->uuid('location_id');
            $table->uuid('company_id');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->dateTime('deadline')->nullable();
            $table->dateTime('posted_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('company_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

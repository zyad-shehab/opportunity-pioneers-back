<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Eloquent\Model;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('skills');
            $table->json('salary');
            $table->date('endDate')->nullable();
            $table->string('typeOfWork');
            $table->string('workTime');
            $table->text('description');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
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
    Schema::create('jobs', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->json('skills');
        $table->decimal('salary_monthly', 8, 2)->nullable();
        $table->decimal('salary_hourly', 8, 2)->nullable();
        $table->date('end_date')->nullable();
        $table->enum('type_of_work', ['onSite', 'remote']);
        $table->enum('work_time', ['fulltime', 'parttime']);
        $table->text('description');
        $table->timestamps();
    });
}
};

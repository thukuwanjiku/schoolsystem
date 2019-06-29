<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsRegistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('student_id');
            $table->timestamp('register_date')->nullable();
            $table->boolean('is_present')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_registers');
    }
}

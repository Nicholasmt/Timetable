<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('course_id')->unsigned();
            $table->smallInteger('active')->default(1);
            $table->timestamps();

            $table->foreign('department_id')
            ->references('id')
            ->on('departments')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_courses');
    }
}

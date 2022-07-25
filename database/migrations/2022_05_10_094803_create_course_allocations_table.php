<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_allocations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id')->unsigned();
            $table->bigInteger('semester_id')->unsigned();
            $table->bigInteger('lecturer_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->smallInteger('lead_lecturer')->default(0);
            $table->smallInteger('active')->default(1);
            $table->timestamps();

            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('semester_id')
            ->references('id')
            ->on('semesters')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('lecturer_id')
            ->references('id')
            ->on('lecturers')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('department_id')
            ->references('id')
            ->on('departments')
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
        Schema::dropIfExists('course_allocations');
    }
}

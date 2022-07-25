<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocation_submissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('semester_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->smallInteger('submitted')->default(0);
            $table->timestamps();

            $table->foreign('semester_id')
            ->references('id')
            ->on('semesters')
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
        Schema::dropIfExists('allocation_submissions');
    }
}

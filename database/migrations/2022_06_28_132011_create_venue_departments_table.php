<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venue_departments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('venue_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->timestamps();

            $table->foreign('venue_id')
            ->references('id')
            ->on('venues')
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
        Schema::dropIfExists('venue_departments');
    }
}

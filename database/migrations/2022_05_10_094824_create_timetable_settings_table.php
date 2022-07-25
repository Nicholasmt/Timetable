<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetableSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetable_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('semester_id')->unsigned();
            $table->mediumText('data_dump');
            $table->smallInteger('active')->default(0);
            $table->timestamps();

            $table->foreign('semester_id')
            ->references('id')
            ->on('semesters')
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
        Schema::dropIfExists('timetable_settings');
    }
}

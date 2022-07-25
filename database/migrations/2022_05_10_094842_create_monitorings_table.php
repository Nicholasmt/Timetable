<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->bigInteger('table_name_id');
            $table->bigInteger('monitored_by')->unsigned();
            $table->smallInteger('no_of_students');
            $table->text('comments');
            $table->enum('observation_key',['A','B','C','D']);
            $table->timestamps();

            $table->foreign('monitored_by')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('monitorings');
    }
}

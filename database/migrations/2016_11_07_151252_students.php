<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Students extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function( Blueprint $table)
                       {
                           $table->increments('id');
                           $table->string('FIO');
                           $table->string('group');
                       });
        
        Schema::create('lends', function( Blueprint $table)
                       {
                           $table->increments('id');
                           $table->integer('students_id')->unsigned();
                           $table->foreign('students_id')->references('id')->on('students');
                           $table->integer('device_id')->unsigned();
                           $table->foreign('device_id')->references('id')->on('devices');
                           $table->dateTime('lend_at');
                           $table->dateTime('lend_to');
                        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

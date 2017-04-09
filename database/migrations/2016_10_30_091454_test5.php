<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Test5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('picture');
            $table->timestamps();
        });
        
        Schema::create('storages', function (Blueprint $table) {
           // $table->increments('device_id');
            $table->integer('device_id')->unsigned()->unique();
            $table->foreign('device_id')->references('id')->on('devices');
            $table->tinyinteger('cell');
            $table->tinyInteger('amount');
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
        //
    }
}

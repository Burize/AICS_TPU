<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Test2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('storages', function (Blueprint $table) {
            $table->increments('device_id');
            $table->tinyinteger('cell');
            $table->tinyInteger('amount');
            $table->timestamps();
        });
        
         Schema::create('devices', function (Blueprint $table) {
           // $table->integer('id')->unsigned();
            $table->increments('id');
            $table->foreign('id')->references('device_id')->on('storages');
            $table->string('title');
            $table->string('description');
            $table->string('picture');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class All extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
         Schema::create('groups', function (Blueprint $t) {
            $t->increments('id');
            $t->string('title',50);
            $t->timestamps();
        });
        
        Schema::create('users', function (Blueprint $t) {
            $t->increments('id');
            $t->string('login',50);
            $t->string('password',255);
            $t->string('email', 50)->unique();
            $t->string('fio',100);
            $t->string('user_type',30)->default("user");
            $t->char('token',6)->unique();
            $t->integer('group_id')->unsigned()->nullable();
            $t->foreign('group_id')->references('id')->on('groups');
            $t->rememberToken();
            $t->timestamps();
        }); 
        
            Schema::create('devices', function (Blueprint $t) {
            $t->increments('id');
            $t->string('title',255);
            $t->text('description');
            $t->timestamps();
        });
       
          Schema::create('storages', function (Blueprint $t) {
           
            $t->integer('device_id')->unsigned();   
            $t->primary('device_id');
            $t->foreign('device_id')->references('id')->on('devices');
            $t->string('cell',20);
            $t->tinyInteger('amount');
            $t->timestamps();
        });
       
          Schema::create('lends', function (Blueprint $t) {
            $t->increments('id');
            $t->integer('user_id')->unsigned();
            $t->foreign('user_id')->references('id')->on('users');
            $t->integer('device_id')->unsigned();
            $t->foreign('device_id')->references('id')->on('devices');
            $t->date('lend_at');
            $t->date('lend_to');
            $t->date('return_at')->nullable();
            $t->smallInteger('lend_amount')->unsigned();
            $t->smallInteger('return_amount')->unsigned()->default(0);
            $t->timestamps();
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

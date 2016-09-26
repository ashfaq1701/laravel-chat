<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('channel_user', function (Blueprint $table) {
    		$table->increments('id');
    		$table->integer('channel_id');
    		$table->integer('user_id');
    		$table->nullableTimestamps();
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('channel_user');
    }
}

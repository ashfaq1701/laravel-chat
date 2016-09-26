<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('messages', function (Blueprint $table) {
    		$table->increments('id');
    		$table->string('type');
    		$table->string('text')->nullable();
    		$table->string('file_path')->nullable();
    		$table->string('mime')->nullable();
    		$table->integer('channel_id');
    		$table->integer('user_id');
    		$table->dateTime('read_at')->nullable();
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
        Schema::drop('messages');
    }
}

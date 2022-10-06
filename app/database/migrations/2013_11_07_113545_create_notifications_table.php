<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) 
		{
			$table->increments('id');
			$table->integer('user_id')->index();
			$table->string('subject');
			$table->text('message');
			// $table->enum('status',array('unread','read'))->default('unread');
			$table->timestamps();			
			$table->softDeletes();
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
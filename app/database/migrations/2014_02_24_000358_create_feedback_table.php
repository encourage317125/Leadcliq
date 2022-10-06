<?php

use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_feedbacks', function($table){
			$table->increments('id');
			$table->integer('seller_id');
			$table->integer('buyer_id');
			$table->integer('contact_id');
			$table->integer('contact_transaction_id');
			$table->integer('points');
			$table->string('comments');
			$table->integer('status');
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
		Schema::drop('contact_feedbacks');
	}

}
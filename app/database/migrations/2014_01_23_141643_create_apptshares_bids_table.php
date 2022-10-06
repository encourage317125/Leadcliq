<?php

use Illuminate\Database\Migrations\Migration;

class CreateApptsharesBidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('apptshares_bids', function($table)
		{
			$table->increments('id');
			$table->integer('apptshare_id');
			$table->integer('bidder_id');
			$table->text('message');
			$table->enum('status', array('pending','rejected','accepted','paid','cancelled'))->default('pending');
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
		Schema::drop('apptshares_bids');
	}

}
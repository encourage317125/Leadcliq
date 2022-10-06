<?php

use Illuminate\Database\Migrations\Migration;

class CreateApptsharesCheckpointsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('apptshares_checkpoints', function($table){
			$table->increments('id');
			$table->integer('apptshare_id');
			$table->string('title');
			$table->decimal('amount',10,2);
			$table->text('description');
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
		Schema::drop('apptshares_checkpoints');
	}

}
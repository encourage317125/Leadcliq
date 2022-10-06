<?php

use Illuminate\Database\Migrations\Migration;

class AddCircleToApptshares extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('apptshares', function($table)
		{
			$table->integer('circle_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('apptshares', function($table)
		{
			$table->dropColumn('circle_id');
		});
	}

}
<?php

use Illuminate\Database\Migrations\Migration;

class AddCallListContact extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contacts', function($table)
		{
		    $table->integer('call_list');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//do nothing
	}

}
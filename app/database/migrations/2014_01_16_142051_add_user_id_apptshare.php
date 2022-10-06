<?php

use Illuminate\Database\Migrations\Migration;

class AddUserIdApptshare extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('apptshares', function($table)
	    {
	    	$table->integer('user_id');
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
	    	$table->dropColumn('user_id');
	    });	
	}

}
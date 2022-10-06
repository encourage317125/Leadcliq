<?php

use Illuminate\Database\Migrations\Migration;

class AddApptshareStatusField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('apptshares', function($table)
	    {
	    	$table->enum('status',array('private','public','sold','cancelled'))->default('private');
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
	    	$table->dropColumn('status');
	    });	
	}

}
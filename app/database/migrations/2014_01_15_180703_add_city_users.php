<?php

use Illuminate\Database\Migrations\Migration;

class AddCityUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('users', function($table)
		{
		    $table->text('city');
		    $table->text('state');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
		    $table->dropColumn('city','state');
		});
	}

}
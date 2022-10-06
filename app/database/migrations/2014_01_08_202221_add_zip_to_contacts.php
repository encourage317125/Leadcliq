<?php

use Illuminate\Database\Migrations\Migration;

class AddZipToContacts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contacts', function($table)
		{
		    $table->text('zip');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contacts', function($table)
		{
		    $table->dropColumn('zip');
		});
	}

}
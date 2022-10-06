<?php

use Illuminate\Database\Migrations\Migration;

class AddOpportunityDetailsToContacts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		Schema::table('contacts', function($table)
		{
		    $table->text('relationship');
		    $table->integer('project_size');
		    $table->date('expiration');
		    $table->string('opportunity_title');
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
		    $table->dropColumn('relationship','project_size','expiration','opportunity_title');
		});
	}

}
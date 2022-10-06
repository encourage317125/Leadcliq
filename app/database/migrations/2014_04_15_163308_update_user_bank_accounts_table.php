<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUserBankAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_banks', function($table)
		{
			$table->dropColumn('name','uri','bank_code','is_valid');
			$table->boolean('can_credit');
			$table->string('verification_uri');
			$table->string('verification_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_banks', function($table)
		{
			$table->string('name');
			$table->string('uri');
			$table->string('bank_code');			
			$table->dropColumn('can_credit','verification_status','verification_uri');
			$table->boolean('is_valid');
		});
	}

}
<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUserCreditCard extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_cards', function($table)
		{
			$table->dropColumn('name','is_verified','is_valid','postal_code_check','security_code_check','card_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_cards', function($table)
		{
			$table->string('name');
			$table->boolean('is_verified');
			$table->boolean('is_valid');
			$table->boolean('postal_code_check');
			$table->boolean('security_code_check');
			$table->string('card_type');
		});
	}

}
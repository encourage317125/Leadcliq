<?php

use Illuminate\Database\Migrations\Migration;

class AddUserCreditCard extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_cards', function($table)
		{
			$table->string('uri')->primary();
			$table->integer('user_id');
			$table->string('name');
			$table->string('last_four',4);
			$table->boolean('is_verified');
			$table->boolean('is_valid');
			$table->boolean('postal_code_check');
			$table->boolean('security_code_check');
			$table->string('card_type');
			$table->string('brand');
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
		Schema::drop('users_cards');
	}

}
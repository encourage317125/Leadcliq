<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserBankAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_banks', function($table)
		{
			$table->string('id')->primary();
			$table->integer('user_id');
			$table->string('name');
			$table->string('uri');
			$table->string('type');
			$table->string('account_number');
			$table->string('bank_code');
			$table->string('bank_name');
			$table->boolean('can_debit');
			$table->boolean('is_valid');
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
		Schema::drop('users_banks');
	}

}
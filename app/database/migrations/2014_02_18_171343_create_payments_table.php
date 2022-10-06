<?php

use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function($table){
			$table->increments('id');
			$table->integer('payment_id');
			$table->string('payment_type');
			$table->string('reference_uri');
			$table->text('description');
			$table->integer('user_id');
			$table->decimal('amount');
			$table->string('status');
			$table->enum('type',array('debit','credit','charge','refund'));
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
		Schema::drop('payments');
	}

}
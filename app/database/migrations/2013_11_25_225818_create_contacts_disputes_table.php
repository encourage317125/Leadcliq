<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateContactsDisputesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('contact_disputes', function(Blueprint $table) {
	    	$table->increments('id');
	    	$table->integer('contact_id');
	    	$table->integer('transaction_id');
	    	$table->integer('buyer_id');
	    	$table->integer('seller_id');
	    	$table->integer('status');
	    	$table->integer('reason');
	    	$table->text('reason_description');
	    	$table->text('report');
	    	$table->integer('resolution');
	    	$table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contact_disputes');
	}

}
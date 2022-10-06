<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class NewTableContactCheckpoints extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
    	Schema::create('contact_checkpoints', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('contact_id')->nullable();
    		$table->text('title')->nullable();
    		$table->text('description')->nullable();
    		$table->integer('price')->nullable();
    		$table->timestamps();
    	});
    	
    	Schema::table('contacts', function($table)
		{
		    $table->integer('price');
		    $table->integer('has_checkpoints');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contact_checkpoints');
		Schema::table('contacts', function($table)
		{
		    $table->dropColumn('price','has_checkpoints');
		});
	}

}
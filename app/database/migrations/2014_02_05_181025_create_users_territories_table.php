<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTerritoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_territories', function($table){
			$table->increments('id');
			$table->string('name');
			$table->integer('user_id');
			$table->string('areatype');
		});
		DB::statement("ALTER TABLE users_territories ADD COLUMN geom GEOMETRY"); 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_territories');
	}

}
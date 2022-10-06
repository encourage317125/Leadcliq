<?php

use Illuminate\Database\Migrations\Migration;

class CreatePolygonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('polygons', function($table){
			$table->integer("id")->primary();
			$table->string("zip");
			$table->string("po_name");
			$table->string("state");
			$table->integer("sumblkpop");
			$table->decimal("pop2007",13,4);
			$table->decimal("pop07_sqmi",13,4);
			$table->decimal("sqmi",13,4);
			$table->integer("oid");
		});
		DB::statement("ALTER TABLE polygons ADD COLUMN shape GEOMETRY"); 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('polygons');
	}

}
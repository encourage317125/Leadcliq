<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLocationIdToUsersTerritories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_territories', function(Blueprint $table) {
            UserTerritory::truncate();
		    $table->integer('location_id')->unsigned()->index();
            $table->foreign('location_id')->references('id')->on('cities')->onDelete('cascade')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_territories', function(Blueprint $table) {
            $table->dropForeign('users_territories_location_id_foreign');  
			$table->dropColumn('location_id');
		});
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanySizeTiersToListingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('listings',function(Blueprint $table){
            $table->integer('company_size_tier_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('listings',function(Blueprint $table){
            $table->dropColumn('company_size_tier_id');
        });
	}

}

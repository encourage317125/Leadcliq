<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIntroductionAvailableToListings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('listings',function(Blueprint $table){
            $table->boolean('introduction_available');
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
            $table->dropColumn('introduction_available');
        });
	}

}

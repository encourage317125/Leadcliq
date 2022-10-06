<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleIdToListings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('listings',function(Blueprint $table){
            $table->dropColumn('contact_title');
            $table->integer('title_id');
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
            $table->dropColumn('title_id');
            $table->string('contact_title');
        });
	}

}

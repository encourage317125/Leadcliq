<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndustryUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function($table){
            $table->integer('industry_id');
        });
        Schema::create('users_seeking_industries', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('industry_id')->unsigned()->index();
            $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('users', function(Blueprint $table) {
            $table->drop('industry_id');
        });
        Schema::drop('users_seeking_industries');
	}

}

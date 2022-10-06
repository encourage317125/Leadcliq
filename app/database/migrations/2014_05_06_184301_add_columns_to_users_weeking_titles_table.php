<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnsToUsersWeekingTitlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_seeking_titles', function(Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('title_id')->unsigned()->index();
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_seeking_titles', function(Blueprint $table) {
	        $table->dropForeign('users_seeking_titles_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropForeign('users_seeking_titles_title_id_foreign');
            $table->dropColumn('title_id');
		});
	}

}

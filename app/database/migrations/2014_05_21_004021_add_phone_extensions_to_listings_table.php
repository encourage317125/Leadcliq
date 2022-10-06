<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneExtensionsToListingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('listings', function(Blueprint $table)
        {
            $table->integer('contact_extension1');
            $table->integer('contact_extension2');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('listings', function(Blueprint $table)
        {
            $table->dropColumn('contact_extension1');
            $table->dropColumn('contact_extension2');
        });
	}

}

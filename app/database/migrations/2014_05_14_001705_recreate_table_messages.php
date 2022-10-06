<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateTableMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('messages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('subject');
            $table->string('to');
            $table->integer('from');
            $table->text('message');
            $table->timestamps();
            $table->datetime('sent_at')->nullable();
            $table->datetime('archived_at')->nullable();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}

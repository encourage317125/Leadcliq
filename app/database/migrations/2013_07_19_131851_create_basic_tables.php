<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBasicTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    	Schema::create('points', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('user_id')->nullable();
    		$table->integer('circle_id')->nullable();
    		$table->integer('sum')->nullable();
    		
    		$table->timestamps();
    	});
    	
    	Schema::create('appointments', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('user_id')->nullable();//owner
            $table->string('title')->nullable();
    		$table->string('location')->nullable();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->string('zip',5);
            $table->text('extra_details')->nullable();
    		$table->datetime('date')->nullable();    		
    		$table->string('industry')->nullable();
    		$table->string('manager_title')->nullable();
            $table->string('manager_name')->nullable();
    		$table->text('notes')->nullable();
    		$table->string('size')->nullable();
    		$table->timestamps();
    	});
    	
    	Schema::create('referals', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('user_id')->nullable();
    		$table->string('from')->nullable();
    		$table->string('to')->nullable();
    		$table->string('subject')->nullable();
    		$table->string('message')->nullable();
    		$table->string('token')->nullable();
    		$table->integer('status')->nullable();
    		$table->timestamps();
    	});
    	
    	Schema::create('circles', function(Blueprint $table) {
    		$table->increments('id');
    		$table->string('name')->nullable()->unique();
    		$table->timestamps();
    	});
    	
    	Schema::create('contacts', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('user_id')->nullable();
    		$table->string('first_name')->nullable();
    		$table->string('last_name')->nullable();
    		$table->string('title')->nullable();
    		$table->string('company')->nullable();
    		$table->string('email')->nullable();
            $table->string('direct_area')->nullable();
    		$table->string('direct')->nullable();
            $table->string('direct_ext')->nullable();
    		$table->string('cell')->nullable();
    		$table->string('general')->nullable();
    		$table->string('general_ext')->nullable();
    		$table->string('notes')->nullable();
    		$table->string('size')->nullable();
    		$table->string('city')->nullable();
    		$table->string('state')->nullable();
    		$table->integer('intro_available')->nullable();
    		$table->integer('opportunity')->nullable();
    		$table->string('opportunity_description')->nullable();
    		
    		$table->timestamps();
    	});
    	
    	Schema::create('contact_transactions', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('contact_id')->nullable();
    		$table->integer('circle_id')->nullable();
    		$table->integer('from')->nullable();
    		$table->integer('to')->nullable();
    		$table->integer('points')->nullable();
    		$table->integer('operation')->nullable();
    		$table->timestamps();
    	});
    	
	    Schema::create('appointment_transactions', function(Blueprint $table) {
	    	$table->increments('id');
	    	$table->integer('appointment_id')->nullable();
	    	$table->integer('circle_id')->nullable();
	    	$table->integer('from')->nullable();
	    	$table->integer('to')->nullable();
	    	$table->integer('points')->nullable();
	    	$table->integer('operation')->nullable();
	    	$table->integer('resolution')->nullable();
	    	$table->timestamps();
	    });
    	
    	Schema::create('circle_user', function(Blueprint $table) {
    		$table->increments('id');
    		$table->datetime('joined_at');
            $table->integer('user_id')->nullable();
            $table->integer('circle_id')->nullable();
            $table->timestamps();
    	});
    	
    	Schema::create('throttle', function(Blueprint $table) {
    		$table->increments('id');
    		$table->integer('user_id')->nullable();
    		$table->string('ip_address')->nullable();
    		$table->integer('attempts')->nullable();
    		$table->integer('suspended')->nullable();
    		$table->integer('banned')->nullable();
    		$table->timestamp('last_attempt_at')->nullable();
    		$table->timestamp('suspended_at')->nullable();
    		$table->timestamp('banned_at')->nullable();
    	});
    	
    	Schema::create('users', function(Blueprint $table) {
    		$table->increments('id');
    		$table->string('permissions')->nullable();
    		$table->integer('activated')->nullable();
            $table->integer('is_admin')->nullable();
    		$table->string('activation_code')->nullable();
    		$table->timestamp('activated_at')->nullable();
    		$table->timestamp('last_login')->nullable();
    		$table->string('persist_code')->nullable();
    		$table->string('reset_password_code')->nullable();
    		$table->timestamps();
    		$table->string('email')->nullable();
    		$table->string('password')->nullable();
    		$table->string('first_name')->nullable();
    		$table->string('last_name')->nullable();
    		$table->string('company')->nullable();
    		$table->string('phone')->nullable();
            $table->string('extension')->nullable();
    		$table->string('title')->nullable();
    		$table->string('services_provide')->nullable();
            $table->string('industry')->nullable();
    		// $table->string('territory_location')->nullable();
    		// $table->string('partners_looking')->nullable();
    		// $table->string('clients_looking')->nullable();
    		$table->string('zip')->nullable(); 
            $table->string('photo')->nullable()->nullable();
    		$table->integer('directory_status')->nullable();
    	});
    	
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	//We are not using DB drops.
        
        Schema::drop('appointments');
        Schema::drop('referals');
        Schema::drop('circles');
        Schema::drop('contacts');
        Schema::drop('contact_transactions');
        Schema::drop('appointment_transactions');
        Schema::drop('circle_user');
        Schema::drop('throttle');
        Schema::drop('users');
        Schema::drop('points');
    }

}

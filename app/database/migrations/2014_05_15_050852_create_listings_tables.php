<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::drop('appointments');

        Schema::create('listings', function(Blueprint $table) {

            //logic columsn for listings
            $table->increments('id');
            $table->string('listing_type');
            $table->integer('seller_id');
            $table->integer('buyer_id');
            $table->integer('price');
            $table->timestamp('expires_at');
            $table->string('listing_title');
            $table->string('listing_description');
            $table->boolean('is_published');
            $table->boolean('is_released');
            $table->integer('company_id');
            $table->integer('city_id'); //actually represents a zip, see cities table
            $table->boolean('can_bid');
            $table->boolean('for_points');
            $table->boolean('has_checkpoints');
            $table->boolean('variable_price');
            $table->string('listing_feedback');
            $table->smallInteger('stars');

            //listing type specific columns
            $table->timestamp('event_at');
            $table->string('address');
            $table->string('gen_address_info');
            $table->string('special_address_info');
            $table->boolean('is_conference');
            $table->string('dialing_instructions');
            $table->string('contact_name');
            $table->string('contact_title');
            $table->string('contact_email');
            $table->integer('contact_phone1');
            $table->integer('contact_phone2');
            $table->integer('contact_cell');
            $table->integer('contact_relationship');
            $table->string('notes');
            $table->boolean('intro_available');
            $table->string('opportunity_description');
            $table->integer('company_size');
            $table->integer('industry_id');
            $table->integer('deal_size_tier_id');

            $table->softDeletes();
            $table->timestamps();

        });

        Schema::create('listing_history', function(Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('listing_id')->unsigned()->index();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('listing_circles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->unsigned()->index();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->integer('circle_id')->unsigned()->index();
            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
        });

        Schema::create('listing_offers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->unsigned()->index();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->integer('circle_id')->unsigned()->index();
            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::create('listing_transaction_checkpoints', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->unsigned()->index();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->string('description');
        });

        Schema::create('revoked_buyers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('buyer_id')->unsigned()->index();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('listing_id')->unsigned()->index();
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('listing_disputes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->unsigned()->index();
            $table->integer('buyer_id')->unsigned()->index();
            $table->boolean('is_by_seller');
            $table->string('reason');
            $table->string('reason_notes');
            $table->string('resolution');
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
        Schema::drop('listings');
        Schema::drop('listing_history');
        Schema::drop('listing_circles');
        Schema::drop('listing_transaction_checkpoints');
        Schema::drop('revoked_buyers');
        Schema::drop('listing_disputes');
    }

}

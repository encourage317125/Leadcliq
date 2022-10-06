<?php
use Illuminate\Database\Migrations\Migration;
class CreateApptshareTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('apptshares',function($table){
				$table->increments('id');
				$table->string('title');
				$table->datetime('appt_datetime');
				$table->datetime('bid_datetime');
				$table->string('address');
				$table->string('zip',6);
				$table->text('gen_address_info');
				$table->text('special_address_info');
				$table->boolean('conference')->default(0);
				$table->string('dial_instructions')->nullable();
				$table->string('manager_name');
				$table->string('manager_title');
				$table->string('company_size');
				$table->string('industry');
				$table->string('project_size');
				$table->text('meeting_description');
				$table->enum('sell_for',array('points','money'))->default('points');
				$table->enum('pay_option', array('one_price','multiple-payout'))->nullable();
				$table->decimal('price',10,2)->default(0);
				$table->timestamps();
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
		Schema::drop('apptshares');
	}
}
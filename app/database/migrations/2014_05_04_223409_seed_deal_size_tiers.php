<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedDealSizeTiers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //0<10,000, 10,000<50,000, 50,000<1,000,000, 1,000,00<
        DealSizeTier::create(array(
            'name'=>'0 < 10,000',
            'min'=>0,
            'max'=>10000
        ));
        DealSizeTier::create(array(
            'name'=>'10,000 < 50,000',
            'min'=>10000,
            'max'=>50000
        ));
        DealSizeTier::create(array(
            'name'=>'50,000 < 1,000,000',
            'min'=>50000,
            'max'=>1000000
        ));
        DealSizeTier::create(array(
            'name'=>'50,000 < 1,000,000',
            'min'=>50000,
            'max'=>10000000000000000000
        ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DealSizeTier::truncate();
	}

}

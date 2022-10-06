<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCompanySizeTiers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		CompanySizeTier::create(array(
            'name'=>'1-10',
            'min'=>1,
            'max'=>10
        ));

        CompanySizeTier::create(array(
            'name'=>'11-50',
            'min'=>11,
            'max'=>50
        ));

        CompanySizeTier::create(array(
            'name'=>'51-500',
            'min'=>51,
            'max'=>500
        ));

        CompanySizeTier::create(array(
            'name'=>'Over 500',
            'min'=>500
        ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('company_size_tiers')->delete();
	}

}

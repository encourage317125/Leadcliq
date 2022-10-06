<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCitiesTable extends Migration {

    var $citiesSQL;

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        //DB::table('cities')->delete();
        DB::table('cities')->delete();

        DB::connection()->disableQueryLog();

        //cities.php contains an array fo a few large sql insert statements
        include __DIR__.'/sql/cities.php';

        $this->citiesSQL = $citiesSQL; //citiesSQL is defiled via cities.php

        foreach ($this->citiesSQL as $statement)
        {
            DB::statement($statement);
            echo count($this->citiesSQL).' remaining';
        }
        echo 'done seeding cities';

    }


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::table('cities')->delete();
    }

}

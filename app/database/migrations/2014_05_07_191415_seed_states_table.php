<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::transaction(function()
        {
            $table = 'states';
            DB::connection()->disableQueryLog();
            DB::table($table)->delete();
            echo('Adding records added into '.$table.' table');
            $file = __DIR__.'/sql/'.$table.'.sql';
            $sql = file_get_contents($file);
            $statements = explode(';', trim($sql));
            $count = 0;
            DB::table($table)->delete();
            foreach ($statements as $statement)
            {
                if($statement == null) continue;
                DB::statement($statement);
                $count ++;
            }
            echo($count.' records added into '.$table.' table');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::table('states')->delete();
    }

}

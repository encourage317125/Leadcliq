<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStateToCities extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cities', function(Blueprint $table) {
			  $table->string('state',22);
                 
		});
        
         DB::statement('UPDATE cities SET state=(SELECT states.name FROM states WHERE states.code=cities.state_code)');  
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cities', function(Blueprint $table) {
			    $table->dropColumn('state');
		});
	}

}

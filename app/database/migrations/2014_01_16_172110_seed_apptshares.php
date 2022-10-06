<?php

use Illuminate\Database\Migrations\Migration;

class SeedApptshares extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Moved this logic into ApptSharesSeeder in Seeds folder
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('apptshares_checkpoints')->delete();
        DB::table('apptshares')->delete();
    }

}
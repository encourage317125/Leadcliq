<?php
class DatabaseSeeder extends Seeder {

	public function run()
	{
        ini_set('memory_limit', '200M');
        $this->command->comment('Seeding Database');

        $environment = App::environment();

//        if ($environment!=='production'){

            //remove query log so we don't run into memory issues
            DB::connection()->disableQueryLog();


            $this->call('UsersSeeder');
            $this->call('CirclesSeeder');
            $this->call('ContactsSeeder');
            $this->call('ApptShareSeeder');

//        }


	}
}


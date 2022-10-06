<?php

class CirclesSeeder extends Seeder
{
	public function run()
	{
        $this->command->comment('Adding circles with users');
        DB::table('circles')->delete();
        DB::table('circle_user')->delete();

        $allUsers = User::all();

        //we must create a circle that everyone is automatically added to (this is also in migrations)
        $openMarketCircle = Circle::create(array('name'=>'Open Market'));
        $openMarketCircle->users()->sync($allUsers->lists('id'));

        $faker = Faker\Factory::create();
        //$faker->addProvider(new Leadcliq\Repositories\Faker\CustomProviders($faker));


        for ($i = 0; $i < 20; $i++)
        {
            //create circle
            $circle = Circle::create(array(
                'name' => $faker->unique()->name
            ));

            //add users at random to circle
            $user_ids = $allUsers->lists('id');
            shuffle($user_ids);
            $stop = rand(0,count($user_ids));

            for($j = 0; $j < $stop; $j++){
                $circle->addUser($user_ids[$j]);
                //todo: here we should gift points (use events though for consistency)
            }

        }

        $this->command->comment('Done adding Circles');

    }
}
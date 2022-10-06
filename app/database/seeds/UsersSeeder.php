<?php

class UsersSeeder extends Seeder
{
	public function run()
	{

        $this->command->comment('Adding 10 test users un:test1@gmail.com p:test for 1-10 + milestones');

        DB::table('users')->delete();

        //use faker to populat models with fake data
        $faker = Faker\Factory::create();
        //$faker->addProvider(new Leadcliq\Repositories\Faker\CustomProviders($faker));

        //create companies (currently we're not populating using migration)
        for ($i=1;$i<10;$i++){
            Company::create(array('name'=>$faker->company));
        }

        $companies = Company::all();
        $titles = Title::all();
        $industries = Title::all();
        $dealSizeTiers = DealSizeTier::all();

        //Populate table with known test emails to login and test with. Password always 'test'
        for ($i=1; $i<=10; $i++){
            User::create(array(
                'activated' => 1,
                'persist_code' => 'reset_code',
                'email' => 'test'.$i."@gmail.com",
                'alias' => 'test'.$i,
                'password' => 'test',
                'first_name' => 'Test First',
                'last_name' => 'Test Last',
                'company_id' => $companies->random()->id,
                'phone' => '(925)222-8426',
                'title_id' => $titles->random()->id,
                'industry_id' => $industries->random()->id,
                'zip' => '94563',
                'city' => 'Orinda',
                'state' => 'California',
                'deal_size_tier_id' => $dealSizeTiers->random()->id
            ));
        }

        //Create random users
        $this->command->comment('Adding 30 random users + milestones');
        for ($i = 0; $i < 30; $i++)
        {
            User::create(array(
                'activated' => 1,
                'persist_code' => 'reset_code',
                'email' => $faker->email,
                'password' => $faker->word,
                'alias' => $faker->userName + $i,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'company_id' => $companies->random()->id,
                'phone' => $faker->numerify('(###)-###-####'),
                'title_id' => $titles->random()->id,
                'industry_id' => $industries->random()->id,
                'zip' => $faker->postcode,
                'city' => $faker->city,
                'state' => $faker->state,
                'deal_size_tier_id' => $dealSizeTiers->random()->id
            ));

        }

	}
}
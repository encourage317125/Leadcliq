<?php

class ContactsSeeder extends Seeder
{
	public function run()
	{
        $this->command->comment('Adding 80 Contacts and ContactTransactions');
        DB::table('contacts')->delete();
        DB::table('contact_transactions')->delete();

        $faker = Faker\Factory::create();
        //$faker->addProvider(new Leadcliq\Repositories\Faker\CustomProviders($faker));

        $allUsers = User::with('circles')->get();
        $userIds = $allUsers->lists('id');

        for ($i = 0; $i < 40; $i++)
        {
            $user_id = $userIds[rand(0,count($userIds)-1)];
            $for_points = rand(0,1);
            $price = $for_points?rand(1,4):5*$faker->randomNumber(1,999);
            //create circle
            $contact = Contact::create(array(
                'user_id' => $user_id,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'title' => $faker->bs,
                'company' => $faker->company,
                'email' => $faker->email,
                'direct_area' => $faker->numerify('(###)-###-####'),
//                'direct' => $faker->,
//                'direct_ext' => $faker->,
                'cell' => $faker->optional()->numerify('(###)-###-####'),
//                'general' => $faker->,
//                'general_ext' => $faker->,
                'expiration' => $faker->dateTimeBetween('now','30 days')->format('Y-m-d H:i:s'),
                'notes' => $faker->text(255),
                'size' => 50*$faker->randomNumber(1,99999),
                'city' => $faker->city,
                'state' => $faker->state,
                'intro_available' => rand(0,1),//0 or 1
                'sell_open_market' => rand(0,1),
                'zip' => $faker->postcode,
                'price' => $price,
                'has_checkpoints' => 0
            ));

            $user = $allUsers->find($user_id);
            $userCircles = $user->circles;

            //this was originally a loop through a random amount of circles
            //but this caused memory errors
            if (isset($userCircles[0])){
                $circle_ids = $userCircles->lists('id');
                shuffle($circle_ids);
                ContactTransaction::create(array(
                    'contact_id'=>$contact->id,
                    'circle_id'=>$circle_ids[0],
                    'from'=>$user_id,
                    'to'=>$user_id,
                    'points'=>$for_points,
                    'operation'=>3
                ));
            }
        }
        $this->command->comment('Done adding Contacts and ContactTransactions');

    }
}
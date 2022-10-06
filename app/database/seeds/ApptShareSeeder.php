<?php

use Illuminate\Database\Migrations\Migration;

class ApptShareSeeder extends Seeder {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function run()
    {

        $this->command->comment('Adding adding 80 ApptShares (some with checkpoints)');

        DB::table('apptshares')->delete();
        DB::table('apptshares_checkpoints')->delete();

        $faker = Faker\Factory::create();
        //todo: I don't think this is needed here
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\DateTime($faker));
        $faker->addProvider(new Faker\Provider\en_US\Address($faker));
        $apptshares =array();

        //generate a random id from circles to add
        $allCircles = Circle::all();
        $circleIds = $allCircles->lists('id');

        $allUsers = User::all();
        $usersIds = $allUsers->lists('id');

        for($i=0; $i <80; $i++)
        {
            $apptshares[$i]['user_id'] = $usersIds[array_rand($usersIds)];
            $apptshares[$i]['title'] = $faker->sentence(rand(5,15));
            $apptshares[$i]['appt_datetime'] = $faker->dateTimeBetween('10 days', rand(12,100).' days')->format('Y-m-d H:i:s');
            $apptshares[$i]['bid_datetime']	= $faker->dateTimeBetween('now', $apptshares[$i]['appt_datetime'])->format('Y-m-d H:i:s');
            $apptshares[$i]['address']	=	$faker->address;
            $apptshares[$i]['zip']	= $faker->postcode;
            $apptshares[$i]['gen_address_info']	= $faker->address;
            $apptshares[$i]['special_address_info']	= $faker->address;
            $apptshares[$i]['conference'] = rand(0,1);
            if($apptshares[$i]['conference'] == 1)
            {
                $apptshares[$i]['dial_instructions'] = $faker->phoneNumber;
            }
            $apptshares[$i]['manager_name']	= $faker->name;
            $apptshares[$i]['manager_title'] = $faker->sentence(rand(1,3));
            $apptshares[$i]['company_size']	= $faker->randomElement(array('50-500','500-1000','1000-10,000','Over 10,000'));
            $apptshares[$i]['industry']	= $faker->sentence(rand(1,3));
            $apptshares[$i]['project_size']	= '$' .rand(1,20)*100;
            $apptshares[$i]['meeting_description'] = $faker->paragraph(4);
            $apptshares[$i]['sell_for']	= $faker->randomElement(array('money','points'));
            $apptshares[$i]['circle_id'] = $circleIds[array_rand($circleIds)];
            $apptshares[$i]['status'] = 'public';
            if($apptshares[$i]['sell_for'] == 'money')
            {
                $apptshares[$i]['pay_option'] = $faker->randomElement(array('one_price','multiple-payout'));
                if($apptshares[$i]['pay_option'] == "one_price")
                {
                    $apptshares[$i]['price'] = $faker->randomNumber(rand(3,6));
                }
            }
        }

        foreach ($apptshares as $appt)
        {
            $apptshare = ApptShare::create($appt);
            if($apptshare->pay_option == 'multiple-payout')
            {
                $z = rand(4,10);
                for ($i=0; $i < $z; $i++)
                {
                    $checkpoint = array(
                        'title' => $faker->sentence(rand(1,3)),
                        'amount' => $faker->randomNumber(rand(2,6)),
                        'description' => $faker->paragraph(rand(3,6)));

                    $checkpoint = new ApptShareCheckpoint($checkpoint);
                    $apptshare->checkpoints()->save($checkpoint);
                }
            }
        }

        $this->command->comment('Done adding ApptShares');

    }

}
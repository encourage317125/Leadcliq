<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PointsTest extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'points:test';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Tests the points system';

    /**
     * Create a new command instance.
     *
     * @return \PointsTest
     */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{

		try
		{

            //test points added on creation
			$user = User::create(array(
		        'email'     => 'user-'.uniqid().'@example.com',
		        'password'  => 'test1234',
		        'first_name' => 'John',
		        'last_name' => 'Doe',
		        'activated' => true,
		    ));
//		    $clean[] = array('table'=>'users','id'=> $user->id);
		    $this->info('Created User ID:'.$user->id);
            $this->info('user points after create: '.$user->totalPointsAllCircles());

            //test points added when twenty contacts uploaded
            for ($i = 0; $i<20; $i++){
                $user = User::create(array(
                    'email'     => 'user-'.uniqid().'@example.com',
                    'password'  => 'test1234',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'activated' => true,
                ));
            }

            //test add to circle



            //test create contact
			$this->info('Successfully completed test');
		}
		catch(Exception $ex)
		{
			$this->info("Error! ".$ex->getMessage());
			// var_dump($ex->getTrace());
		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			
		);
	}

}
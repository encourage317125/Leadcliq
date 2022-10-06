<?php

use Christiaan\ZohoCRMClient\ZohoCRMClient;

class ZohoCRMController extends BaseController
{
	public function run()
	{
		$users = array();
		$client = new ZohoCRMClient('Leads', '36c2932d64c8b112bef7c001608f8446');

		$beta = DB::connection('crm')->select('select * from sign_up where on_zoho = 0');
		$i = 0;

		foreach ($beta as $user) 
		{
			try
			{
				$record = array(
				'First Name' => (isset($user->first_name)?$user->first_name:'n/a'),
				'Last Name' => (isset($user->last_name)?$user->last_name:'n/a'),
				'Company' => (isset($user->company)?$user->company:'n/a'),
				'Email' => $user->email,
				'Lead Source' => 'Beta Users',
				);
				$client->insertRecords()->addRecord($record)->request();
				DB::connection('crm')->update('update sign_up set on_zoho = 1 where id = ?', array($user->id));
				$i++;
			}
			catch(Exception $ex)
			{
				DB::connection('crm')->update('update sign_up set on_zoho = -1 where id = ?', array($user->id));
			}
		}

		echo $i.' users added to beta <br>';

		$newsletter = DB::connection('crm')->select('select * from subscribe where on_zoho = 0');
		$i = 0;

		foreach ($newsletter as $user) 
		{
			try
			{
				$record = array(
				'First Name' => 'n/a',
				'Last Name' => 'n/a',
				'Company' => 'n/a',
				'Email' => $user->email,
				'Lead Source' => 'Newsletter',
				);
				$client->insertRecords()->addRecord($record)->request();
				DB::connection('crm')->update('update subscribe set on_zoho = 1 where id = ?', array($user->id));
				$i++;
			}
			catch(Exception $ex)
			{
				DB::connection('crm')->update('update subscribe set on_zoho = -1 where id = ?', array($user->id));
			}
		}

		echo $i.' users added to newsletter';
	}
}
<?php
require ('composers/autoload.php');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before'=>array('isAdmin')),function()
{
	Route::get('admin/contacts-open-disputes', 		array('as' => 'contacts-open-disputes', 'uses' => 'ContactDisputeController@showOpenDisputes'));
	Route::get('admin/contacts-all-disputes', 		array('as' => 'contacts-all-disputes', 'uses' => 'ContactDisputeController@showAllDisputes'));
	Route::get('admin/contact-dispute/{id}', 		'ContactDisputeController@showDispute');
	Route::post('admin/resolve-dispute/{id}', 		'ContactDisputeController@resolveDispute');

    //for now messages can only be created as admin
    Route::get('messages/sent',array('as'=>'message.sent','uses' =>'MessagesController@sent'));
	Route::get('messages/draft',array('as'=>'message.draft','uses' =>'MessagesController@draft'));
    Route::get('messages/compose/{id?}',array('as'=>'message.compose','uses' =>'MessagesController@compose'));
    Route::post('messages/compose',array('as'=>'message.compose','uses' =>'MessagesController@save'));
    Route::get('messages/reply/{id}','MessagesController@reply');
});

Route::group(array('before'=>array('auth')),function()
{
	//Marketplace (Not working: Moved logic to profile/billing and resource controllers)
//	Route::get('market/profile','MarketplaceController@profile');
//	Route::get('market/user','MarketplaceController@user');
//	Route::get('market/activate','MarketplaceController@activate');
//	Route::post('market/addcard','MarketplaceController@addCard');
//	Route::post('market/addbank','MarketplaceController@addBank');

	Route::get('apptshares/mybids',array('as'=>'apptshares.mybids','uses' =>'ApptShareController@myBids'));
	Route::get('apptshares/{id}/bid',array('as'=>'apptshares.bid','uses' =>'ApptShareController@bidForm'));
	Route::post('apptshares/{id}/bid',array('uses' =>'ApptShareController@bid'));
	Route::get('apptshares/{id}/public',array('as'=>'apptshares.public','uses' =>'ApptShareController@makePublic'));
	Route::get('apptshares/{id}/private',array('as'=>'apptshares.private','uses' =>'ApptShareController@makePrivate'));
	Route::get('apptshares/{id}/cancel',array('as'=>'apptshares.cancel','uses' =>'ApptShareController@cancel'));
	Route::get('apptshares/bid/{id}/accept',array('as'=>'apptshares.accept','uses' =>'ApptShareController@accept'));
	Route::get('apptshares/bid/{id}/reject',array('as'=>'apptshares.reject','uses' =>'ApptShareController@reject'));
	Route::get('apptshares/{id}/rejectall',array('as'=>'apptshares.reject_all','uses' =>'ApptShareController@rejectAll'));
	Route::get('apptshares/market',array('as'=>'apptshares.market','uses' =>'ApptShareController@market'));
	Route::get('apptshares/circle/{id}',array('as'=>'apptshares.circle','uses' =>'ApptShareController@circle'));
	Route::get('apptshares/pay/{id}',array('as'=>'apptshares.get_pay','uses' =>'ApptShareController@pay'));
	Route::post('apptshares/pay/{id}',array('as'=>'apptshares.pay','uses' =>'ApptShareController@pay'));
    
    Route::get('apptshares/territory',array('as'=>'apptshares.territory','uses' =>'ApptShareController@territory'));
    
	Route::resource('apptshares','ApptShareController');

	// Circle - do not require a complete profile to view circles listing. TODO separate viewing and joining circles, from others.
	Route::resource('circles', 'CirclesController');
	Route::post('circles.join/{id}', array('as' => 'circles.join', 'uses' => 'CirclesController@join'));
	Route::post('circles.leave/{id}', array('as' => 'circles.leave', 'uses' => 'CirclesController@leave'));
	Route::get('my-circles', array('as' => 'my-circles', 'uses' => 'ProfileController@myCircles'));
	
	//Profile
	Route::get('profile.complete', array('as' => 'profile.complete', 'uses' => 'ProfileController@completeSteps'));
	Route::post('profile.update',array('as' => 'profile.update','uses' => 'UsersController@update',));
	Route::post('profile.updatePassword',array('as' => 'profile.updatePassword','uses' => 'UsersController@updatePassword',));
	Route::post('profile.updateOnly',array('as' => 'profile.updateOnly','uses' => 'UsersController@updateOnly',));
	Route::post('profile/update/picture', 'UsersController@update_picture');
	Route::get('profile/update/picture/delete', 'UsersController@delete_picture');
    Route::get('profile/billing', 'ProfileController@billing');
    Route::get('profile.delete', array('as' => 'profile.destroy', 'uses' => 'UsersController@destroy'));

    // API for Selectize Tags Implementation
    Route::get('companies_worked_with','UsersController@companiesWorkedWith');
    Route::get('offers_services','UsersController@offersServices');
    Route::get('seeking_titles','UsersController@seekingTitles');
    Route::get('target_industries','UsersController@targetIndustries');
    Route::get('networks_with_titles','UsersController@networksWithTitles');
    Route::get('complementary_services','UsersController@complementaryServices');
    

    //Territories AJAX controller
    Route::resource('api/user-territories','UserTerritoriesController');


	//GeoData

	Route::get('geo/country/{iso2}','GeoDataController@getCountry');

    Route::resource('companies', 'CompaniesController');
    Route::resource('services', 'ServicesController');
    Route::resource('industries', 'IndustriesController');
    Route::resource('titles', 'TitlesController');
    Route::resource('deal-size-tiers', 'dealSizeTiersController');



    //Route::resource('city', 'CitiesController');
    Route::get('city/find/{location}', array('as' => 'city', 'uses' => 'CitiesController@find'));
	// Cities and zips 
	//Route::get('city', function()
//	{
//		$zip = Input::get('zip');
//        
//		$city = City::with('state')->where('zip',$zip)->first();			
//			if($city)
//				return Response::json($city->toArray());
//			else
//				return Response::json(array('error'=>true, 'message'=>"no city for zip $zip"));
//	});

	Route::get('zip', function()
	{
		$term = Input::get('term');
		
		$cities = City::select('zip')->where('zip', 'LIKE', $term.'%')->get();
		$zip = array();		
		foreach ($cities as $city)
		{
			$zip[] = $city->zip;			
		}
		return Response::json($zip);
		
	});
	
	Route::get('cities-per-state', function()
	{
		$state = Input::get('state_code');
		$cities = City::select('name')->where('state_code', '=', $state)->orderBy('name', 'ASC')->get();

		$result = array();
		foreach ($cities as $city)
		{
			$result[$city->name] = $city->name;
		}
		return Response::json($result);
	});

	Route::get('city', function()
	{
		$zip = Input::get('zip');
		$city = City::where('zip', '=', $zip)->orderBy('name', 'ASC')->get()->first();
		return Response::json($city);
	});

	//Authentication
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthenticationController@logout'));
});

Route::group(array('before'=>array('auth','profileComplete')),function()
{
	
	//Home
	Route::get('/', 'HomeController@index');
	Route::get('/home',  array('as' => 'home', 'uses' => 'HomeController@index'));

	//Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'UsersController@profile'));
	Route::get('profile.edit', array('as' => 'profile.edit', 'uses' => 'UsersController@edit'));

	//Directory
	Route::get('directory', array('as' => 'directory', 'uses' => 'UsersController@directory',));

	//Referrals
	Route::get('invite-friends',array('as' => 'invite-friends', 'uses' => 'ProfileController@inviteFriends',));
	Route::post('invite-friends',array('as' => 'send-invite-friends', 'uses' => 'ProfileController@sendInviteFriends','before' => 'login'));
	Route::get('my-referals',array('as' => 'my-referals', 'uses' => 'ProfileController@myReferals',));
	
    
	//Contacts
	Route::resource('contacts', 'ContactsController');
	Route::get('modal-contact-edit/{id}',array('as' => 'modal-contact-edit', 'uses' => 'ContactsController@modalEdit'));
	Route::get('modal-contact-opportunity-edit/{id}',array('as' => 'modal-contact-opportunity-edit', 'uses' => 'ContactsController@modalOpprtEdit'));
	Route::post('contact-update/{id}',array('as' => 'contact-update', 'uses' => 'ContactsController@updateOnly'));
	Route::post('parse-contacts-file',array('as' => 'parse-contacts-file', 'uses' => 'ContactsController@parseFile'));
	Route::post('save-mass-contacts',array('as' => 'save-mass-contacts', 'uses' => 'ContactsController@saveMassContacts'));
	Route::post('delete-contact/{id}',array('as' => 'delete-contact', 'uses' => 'ContactsController@delete'));
	Route::get('show-bougth-contact/{id}', array('as' => 'show-bougth-contact', 'uses' => 'ContactsController@showBougthContact'));
	Route::get('my-contacts', array('as' => 'my-contacts', 'uses' => 'ProfileController@myContacts'));
	Route::get('buy-contacts', array('as' => 'buy-contacts', 'uses' => 'ProfileController@buyContacts'));
	Route::get('sell-contacts',array('as' => 'sell-contacts', 'uses' => 'ProfileController@sellContacts',));
	Route::post('put-public/{id}',array('as' => 'put-public', 'uses' => 'ContactTransactionsController@putPublic'));
	Route::post('put-private/{id}',array('as' => 'put-private', 'uses' => 'ContactTransactionsController@putPrivate'));
	Route::post('buy-contact/{contact_id}/{circle_id}',array('as' => 'buy-contact', 'uses' => 'ContactTransactionsController@buyContact'));
	//Open market pay contact
	Route::get('show-pay-contact/{contact_id}',array('as' => 'show-pay-contact', 'uses' => 'ContactsController@pay'));
    Route::get('paypal-pay/{contact_id}',array('as' => 'show-pay-contact-paypal', 'uses' => 'ContactsController@paypalPay'));
    Route::get('finish-paypal-pay/{contact_id}',array('as' => 'finish-pay-contact-paypal', 'uses' => 'ContactsController@paypalPayFinish'));
    Route::post('pay-contact/{contact_id}',array('as' => 'pay-contact', 'uses' => 'ContactsController@pay'));

	//Call list
	Route::get('contact-remove-call-list/{id}', 'ContactsController@removeCallList');

	//Feedback
	Route::post('add-contact-feedback/{feedback_id}',array('as' => 'add-contact-feedback', 'uses' => 'FeedbackController@addContactFeedback'));

	// Sell contact
	Route::get('sell-contact-how/{id}',array('as' => 'sell-contact-how', 'uses' => 'ContactsController@sellContactHow'));
	Route::get('sell-contact-points/{id}',array('as' => 'sell-contact-points', 'uses' => 'ContactsController@sellContactPoints'));
	Route::get('sell-contact-money/{id}',array('as' => 'sell-contact-money', 'uses' => 'ContactsController@sellContactMoney'));
	Route::post('put-contact-sell-points/{id}',array('as' => 'put-contact-sell-points', 'uses' => 'ContactTransactionsController@putForSellPoints'));
	Route::post('put-contact-sell-money/{id}',array('as' => 'put-contact-sell-money', 'uses' => 'ContactTransactionsController@putForSellMoney'));

	// Contacts disputes
	Route::get('contact/{id}/prepare-dispute',array('as' => 'prepare-dispute', 'uses' => 'ContactDisputeController@prepareDispute'));
	Route::post('contact/{id}/open-dispute',array('as' => 'open-dispute', 'uses' => 'ContactDisputeController@openDispute'));

	// Open Market
	Route::get('open-market', array('as' => 'open-market', 'uses' => 'OpenMarketController@index'));
	Route::get('open-market/contacts', array('as' => 'open-market-contacts', 'uses' => 'OpenMarketController@showContacts'));
	Route::get('open-market/appts', array('as' => 'open-market-appts', 'uses' => 'OpenMarketController@showAppts'));

	// Appointments
	Route::resource('appointments','AppointmentsController');

    //Listing : this is for Apptshare & Contacts
    
    Route::resource('listings','ListingsController');    
    
    Route::get('my-listings', array('as' => 'my-listings', 'uses' => 'ProfileController@myListings'));    
    
    Route::post('parse-listings-file',array('as' => 'parse-listings-file', 'uses' => 'ListingsController@parseFile'));
    Route::post('save-mass-listings',array('as' => 'save-mass-listings', 'uses' => 'ListingsController@saveMassListings'));

    //Route::get('my-appointments', array('as' => 'my-appointments', 'uses' => 'ProfileController@myAppointments'));
	Route::get('my-appointments', array('as' => 'my-appointments', 'uses' => 'AppointmentsController@index'));
	Route::get('bid-appointments', array('as' => 'bid-appointments', 'uses' => 'ProfileController@bidAppointments'));
	Route::get('sell-appointments',array('as' => 'sell-appointments', 'uses' => 'AppointmentsController@sell',));
	Route::post('appointment-update/{id}',array('as' => 'appointment-update', 'uses' => 'AppointmentsController@updateOnly'));
	Route::post('bid-appointment/{appointment_id}/{circle_id}',array('as' => 'bid-appointment', 'uses' => 'AppointmentTransactionsController@bidAppointment'));
	Route::post('bid-accept-appointment/{bid_id}',array('as' => 'bid-accept-appointment', 'uses' => 'AppointmentTransactionsController@bidAcceptAppointment','before' => 'login'));
	Route::post('bid-reject-appointment/{bid_id}',array('as' => 'bid-reject-appointment', 'uses' => 'AppointmentTransactionsController@bidRejectAppointment','before' => 'login'));
	Route::post('appointments/cancel/{id}','AppointmentTransactionsController@cancelAppointment');
	Route::post('put-for-sell-appt/{id}',array('as' => 'put-for-sell-appt', 'uses' => 'AppointmentTransactionsController@putForSell'));
	Route::post('put-for-sell-mass-appt',array('as' => 'put-for-sell-mass-appt', 'uses' => 'AppointmentTransactionsController@putForSellMass'));
	Route::post('put-public-appt/{id}',array('as' => 'put-public-appt', 'uses' => 'AppointmentTransactionsController@putPublic'));
	Route::post('put-private-appt/{id}',array('as' => 'put-private-appt', 'uses' => 'AppointmentTransactionsController@putPrivate'));

	//Notifications
	Route::delete('notifications/{id}','NotificationsController@delete');
	Route::get('notifications/delete/{id}','NotificationsController@delete');

	// Reporting
	Route::get('prepare-report-user/{id}',array('as' => 'prepare-report-user', 'uses' => 'ReportController@prepareReportModal'));
	Route::post('send-report-user/{id}',array('as' => 'send-report-user', 'uses' => 'ReportController@sendReport'));

	//Messaging
	Route::get('messages','MessagesController@inbox');
	Route::get('messages/inbox','MessagesController@inbox');
	Route::get('messages/unread','MessagesController@unread');
//	Route::get('messages/sent','MessagesController@sent');
//	Route::get('messages/draft','MessagesController@draft');
	Route::get('messages/trash','MessagesController@trash');
//	Route::get('messages/compose/{id?}','MessagesController@compose');
//	Route::post('messages/compose','MessagesController@send');
	Route::get('messages/read/{id}',array('as'=>'messages.view','uses' =>'MessagesController@read'));
//	Route::get('messages/reply/{id}','MessagesController@reply');
	Route::delete('messages/{id}','MessagesController@delete');
	Route::delete('messages/destroy/{id}','MessagesController@destroy');
    Route::get('messages/archive_messages',array('as'=>'message.archive_messages','uses' =>'MessagesController@archive_messages'));


    //Resource Controllers
    Route::resource('credit-cards', 'CreditCardsController');
    Route::resource('bank-accounts', 'BankAccountsController');

});

Route::group(array('before'=>array('guest')),function()
{
	//Sign up/in
	Route::get('login', array('as' => 'login', 'uses'=>'AuthenticationController@login_form'));
	Route::get('register',array('as' => 'register','uses' => 'AuthenticationController@registration_form' ));
	Route::get('user/activate','AuthenticationController@activate');
	Route::get('forgot_password',array('as' => 'forgot_password', 'uses' => 'AuthenticationController@forgot_password_form'));
	Route::post('forgot_password', 'AuthenticationController@forgot_password');
	Route::get('user/reset-password','AuthenticationController@reset_password_form');
	Route::post('user/reset-password','AuthenticationController@reset_password');
	Route::post('login', 'AuthenticationController@login');
	Route::post('register', 'AuthenticationController@register');
});

//Event::listen('user.create', function($user)
//{
//    PointsController::addPoints($user->id,0,1);
//});




//Zoho Updater
Route::get('zoho.update', 'ZohoCRMController@run');

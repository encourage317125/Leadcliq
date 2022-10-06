<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	Event::fire('clockwork.controller.start');
});


App::after(function($request, $response)
{
	Event::fire('clockwork.controller.end');
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (!Sentry::check())
	{
		//if accessing a specific page redirect to it
		$url = Request::url();
		if($url != 'login' || $url != 'profile' || $url != '') Session::put('redirect',$url);		
		return Redirect::route('login')->with('message', 'Please log in to continue');
	}	
});

if(Sentry::check())
{
	View::composer('layouts.main',function($view)
	{
		$view->with('user',Sentry::getUser());
	});
}


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Admin Filter
|--------------------------------------------------------------------------
|
*/

Route::filter('isAdmin', function()
{
	$user = Sentry::getUser();
    if(!$user){
        return Redirect::route('login')->with('message', 'Please log in to continue');
    }
	if(!$user->is_admin){
		return Redirect::to('profile')->with('message', 'Can not access this');
	}
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Sentry::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});



/*
|--------------------------------------------------------------------------
| Login required to continue
|--------------------------------------------------------------------------
|
| The user will have to be logued in in order to continue.
| 
|
*/


Route::filter('profileComplete',function()
{
	$user = Sentry::getUser();
	$validation = Validator::make($user->toArray(), User::$profile_completed,User::$messages);
	if(!$validation->passes())
	{
		return Redirect::to('profile.complete')->with('message','Please complete your profile before proceeding');
	}

	// User has to be in at least one circle to do whatever
	$results = DB::table('circle_user')->where('user_id', '=', $user->id)->count();
	if($results == 0)
	{
		return Redirect::route('circles.index')->with('message', 'Please join at least one circle to continue.');
	}
});




/*
|--------------------------------------------------------------------------
| VALIDATIONS for the models
|--------------------------------------------------------------------------
|
| Add here the custom rules for models.
| remember to add the message in the validation.php file
|
*/


// Email can't have more than 4 consecutive digits
Validator::extend('digits4top', function($attribute, $value, $parameters){
	if(preg_match('/(\d{5})/', $value) == 1){
		return false;
	}
	return true;
});


// Email cant't end in any other domain than this ones
Validator::extend('alloweddomains', function($attribute, $value, $parameters){
	$domains = array('.com', '.edu', '.net', '.org', '.info', '.us', '.gov');
	
	foreach ($domains as $domain) {
		if(ends_with($value, $domain)){
			return true;
		}
	}
	
	return false;
});
	
























<?php

use Illuminate\Support\ServiceProvider;

class LeadCliqServiceProvider extends ServiceProvider
{
	public function register()
	{
		//Bind our repositories for ioc injections
		App::bind('AuthenticationRepository','EloquentAuthenticationRepository');
		App::bind('ReferralRepository','EloquentReferralRepository');
		App::bind('MessagesRepository','EloquentMessagesRepository');
		App::bind('NotificationsRepository','EloquentNotificationsRepository');
		App::bind('ApptSharesInterface','Eloquent\ApptSharesRepository');
		App::bind('Leadcliq\Repositories\Payments\PaymentsContract', 'Leadcliq\Repositories\Payments\BalancedPayments');
	}
}
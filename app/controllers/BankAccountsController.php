<?php

//TODO: Currently we're only using Create and Store methods. Can delete other

class BankAccountsController extends \BaseController {

	/**
	 * Display a listing of bankaccounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$bankaccounts = BankAccount::all();

        $redirect = Input::get('redirect');

		return View::make('bankaccounts.index', compact('bankaccounts'))->with('redirect',$redirect);
	}

	/**
	 * Show the form for creating a new creditcard
	 *
	 * @return Response
	 */
	public function create()
	{
        $redirect = Input::get('redirect');
		return View::make('bankaccounts.create')->with('redirect',$redirect);
	}

	/**
	 * Store a newly created creditcard in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $data = Input::all();
        $redirect = $data['redirect'];

        $balanced = new Leadcliq\Repositories\Payments\BalancedPayments();
		$balanced->addBank($data['uri']);

        if ($redirect){
            return Redirect::to($redirect);
        }
		return Redirect::route('credit-cards.index');
	}

	/**
	 * Display the specified creditcard.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bankaccount = BankAccount::findOrFail($id);


		return View::make('bankaccounts.show', compact('creditcard'));
	}

	/**
	 * Show the form for editing the specified creditcard.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bankaccount = BankAccount::find($id);

		return View::make('bankaccounts.edit', compact('creditcard'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$bankaccount = BankAccount::findOrFail($id);

		$validator = Validator::make($data = Input::all(), BankAccount::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bankaccount->update($data);

		return Redirect::route('credit-cards.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		BankAccount::destroy($id);

		return Redirect::route('credit-cards.index');
	}

}
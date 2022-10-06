<?php

class CreditCardsController extends \BaseController {

	/**
	 * Display a listing of creditcards
	 *
	 * @return Response
	 */
	public function index()
	{
		$creditcards = CreditCard::all();

        $redirect = Input::get('redirect');

		return View::make('creditcards.index', compact('creditcards'))->with('redirect',$redirect);
	}

	/**
	 * Show the form for creating a new creditcard
	 *
	 * @return Response
	 */
	public function create()
	{
        $redirect = Input::get('redirect');
		return View::make('creditcards.create')->with('redirect',$redirect);
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
        unset($data['redirect']);
        unset($data['name_on_card']);
        unset($data['expiration_month']);
        unset($data['expiration_year']);
        unset($data['security_code_(CVV)']);

//		$validator = Validator::make($data, Creditcard::$rules);
//
//		if ($validator->fails())
//		{
//			return Redirect::back()->withErrors($validator)->withInput();
//		}

        $balanced = new Leadcliq\Repositories\Payments\BalancedPayments();
		$balanced->addCard($data);

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
		$creditcard = CreditCard::findOrFail($id);


		return View::make('creditcards.show', compact('creditcard'));
	}

	/**
	 * Show the form for editing the specified creditcard.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$creditcard = Creditcard::find($id);

		return View::make('creditcards.edit', compact('creditcard'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$creditcard = Creditcard::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Creditcard::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$creditcard->update($data);

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
		Creditcard::destroy($id);

		return Redirect::route('credit-cards.index');
	}

}
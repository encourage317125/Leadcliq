<?php

class DealSizeTiersController extends \BaseController {

	/**
	 * Display a listing of dealsizetiers
	 *
	 * @return Response
	 */
	public function index()
	{
		$dealsizetiers = Dealsizetier::all();

		return View::make('dealsizetiers.index', compact('dealsizetiers'));
	}

	/**
	 * Show the form for creating a new dealsizetier
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('dealsizetiers.create');
	}

	/**
	 * Store a newly created dealsizetier in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Dealsizetier::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Dealsizetier::create($data);

		return Redirect::route('dealsizetiers.index');
	}

	/**
	 * Display the specified dealsizetier.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$dealsizetier = Dealsizetier::findOrFail($id);

		return View::make('dealsizetiers.show', compact('dealsizetier'));
	}

	/**
	 * Show the form for editing the specified dealsizetier.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dealsizetier = Dealsizetier::find($id);

		return View::make('dealsizetiers.edit', compact('dealsizetier'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$dealsizetier = Dealsizetier::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Dealsizetier::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$dealsizetier->update($data);

		return Redirect::route('dealsizetiers.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Dealsizetier::destroy($id);

		return Redirect::route('dealsizetiers.index');
	}

}
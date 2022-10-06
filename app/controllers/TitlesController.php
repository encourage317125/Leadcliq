<?php

class TitlesController extends \BaseController {

	/**
	 * Display a listing of titles
	 *
	 * @return Response
	 */
	public function index()
	{
		//allow user to filter by query string
        $query = Input::all();
        if (isset($query['keyword'])){
            $string = "%".$query['keyword']."%";
            $titles = Title::where('name','LIKE',$string)->get();
        }else{
            $titles = Title::all();
        }

        return Response::json($titles);
	}

	/**
	 * Show the form for creating a new title
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('titles.create');
	}

	/**
	 * Store a newly created title in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$title = new Title;
		$title->name = Input::get('name');
		$title->save();
		
		return Response::json( $title );
		/*
		$validator = Validator::make($data = Input::all(), Title::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Title::create($data);

		return Redirect::route('titles.index');
		*/
	}

	/**
	 * Display the specified title.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$title = Title::findOrFail($id);

		return View::make('titles.show', compact('title'));
	}

	/**
	 * Show the form for editing the specified title.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$title = Title::find($id);

		return View::make('titles.edit', compact('title'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$title = Title::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Title::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$title->update($data);

		return Redirect::route('titles.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Title::destroy($id);

		return Redirect::route('titles.index');
	}

}
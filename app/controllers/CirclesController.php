<?php

class CirclesController extends BaseController {

    /**
     * Circle Repository
     *
     * @var Circle
     */
    protected $circle;
    
    public function __construct(Circle $circle)
    {
        $this->circle = $circle;
    }

    public function getCircle($id){
    	return $this->circle->findOrFail($id);
    }
    
    public function getAllCircles(){
    	return $this->circle->all();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $circles = $this->circle->all();
        $user = $this->getLoguedUser();


        return View::make('circles.index', compact('circles', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    	$user = $this->getLoguedUser();
        return View::make('circles.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, Circle::$rules);

        if ($validation->passes())
        {
            $this->circle->create($input);

            return Redirect::route('circles.index');
        }

        return Redirect::route('circles.create')
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $circle = $this->circle->findOrFail($id);
        $users = $circle->users;
        
        return View::make('circles.show', compact('circle', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $circle = $this->circle->find($id);

        if (is_null($circle))
        {
            return Redirect::route('circles.index');
        }

        $user = $this->getLoguedUser();
        
        return View::make('circles.edit', compact('circle', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, Circle::$rules);

        if ($validation->passes())
        {
            $circle = $this->circle->find($id);
            $circle->update($input);

            return Redirect::route('circles.show', $id);
        }

        return Redirect::route('circles.edit', $id)
            ->withInput()
            ->withErrors($validation)
            ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->circle->find($id)->delete();

        return Redirect::route('circles.index');
    }
    
    /**
     * The logued user leaves a circle
     *
     * @param integer $circle_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leave($circle_id){
    	$user_id = Sentry::getUser()->id;
    	$circle = $this->circle->findOrFail($circle_id);
    	
    	$circle->users()->detach($user_id);
    	$circle->save();
	    	
    	return Redirect::route('my-circles')->with('message', 'You no longer belong to circle <strong>'.$circle->name.'</strong>');
    }
    
    
    /**
     * The logued user joins a circle
     * 
     * @param integer $circle_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join($circle_id){
    	$user_id = Sentry::getUser()->id;
        $circle = Circle::findOrFail($circle_id);
        $circle->addUser($user_id);
    	return Redirect::route('my-circles');
    }

}








<?php

class UserTerritoriesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Sentry::getUser();
        $territories = $user->userTerritories;
        return Response::json($territories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //todo: remove this since we're using json
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user = Sentry::getUser();
        $id = Sentry::getUser()->id;

//        $geom = UserTerritory::ArrayToGeometry(Input::get('geom')); //we receive geometry in coordinates, we need to convert
        UserTerritory::create(array(
            'name' => Input::get('name'),
            'areatype' => Input::get('areatype'),
            'user_id'=> Sentry::getUser()->id,
            'location_id'=> Input::get('id')
        ));

        return Response::json(array('success' => true));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //todo: remove this
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //todo: remove this
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        UserTerritory::destroy($id);

        return Response::json(array('success' => true));
    }

}
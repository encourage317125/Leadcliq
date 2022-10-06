<?php

class IndustriesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //allow user to filter by query string
        $query = Input::all();
        if (isset($query['keyword'])){
            $string = "%".$query['keyword']."%";
            $industries = Industry::where('name','LIKE',$string)->get();
        }else{
            $industries = Industry::all();
        }
        
        return Response::json($industries);
    }

    public function store()
    {
        $industry = new Industry;
        $industry->name = Input::get('name');
        $industry->save();
        
        return Response::json( $industry );
    }
}
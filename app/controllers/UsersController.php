<?php

class UsersController extends BaseController {

    /**
     * User Repository
     *
     * @var User
     */
    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    
    /**
     * Get User object
     *
     */
    public function getUser($id){
    	return $this->user->findOrFail($id);
    }
    
    /**
     * Display a listing for the Directory
     *
     * @return Response
     */
    public function directory(){
        $user = $this->getLoguedUser();
        
        $userMyCircles = array();
        
        foreach ($user->circles as $circle) {

          foreach ($circle->users as $cUser) {
             if($cUser->directory_status == User::$VISIBLE_ONLY_MY_CIRCLES){
                $userMyCircles[$cUser->id] = $cUser;				
            }
        }
    }

    $users = User::where('directory_status', '=', User::$VISIBLE_FOR_ALL)->get();

    return View::make('users.directory', compact('user', 'users', 'userMyCircles'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(){
        return View::make('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validation = Validator::make($input, User::$rules, User::$messages);

        if ($validation->passes())
        {
            $user = $this->user->create($input);
            
            return Redirect::route('users.index');
        }

        return Redirect::route('users.create')
        ->withInput()
        ->withErrors($validation)
        ->with('message', 'There were validation errors.');
    }


    /**
     * Show user profile
     * 
     */
    public function profile(){
    	$user = $this->user->where('id',Sentry::getUser()->id)->first();
        if(isset($user->zip))
        {
            $user->city = City::with('state')->find($user->zip);
        }
    	
    	echo View::make('users.profile', compact('user'));
    	
    	//Show after login things
    	if(@Session::get('afterlogin') == true){
          $this->afterLogin($user);
      }

      return;
  }

    /**
     * if afterlogin, then:
     * 
     * - Welcome message
     * - Modal windows: Steps uncompleted
     * 
     * TODO talk to see what else we want the user to see after login
     * 
     * @param User $user
     */
    public function afterLogin(User $user){
    	$validation = Validator::make($user->toArray(), User::$profile_completed, User::$messages);
    	if(!$validation->passes()){
    		echo View::make('users.modal.complete-profile', compact('user'))->with('errors',$validation->messages());
    		echo "<script>$('#step-1').modal('show')</script>";

    		//Not needed in Beta launch since we have only 2 groups: Requested by Gina
//     		$circles = (new CirclesController(new Circle()))->getAllCircles();
//     		echo View::make('users.modal.join-circle', compact('user', 'circles'));
    	}
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $user = $this->user->find(Sentry::getUser()->id);

        if (is_null($user))
        {
            return Redirect::route('profile');
        }

        return View::make('users.edit', compact('user'));
    }
    
    /**
     * Updates without validation, used in steps or ajax calls
     *
     * @param  int  $id
     * @return Response
     */
    public function updateOnly()
    {
        $input = array_except(Input::all(), '_method');

//        /**
//         * Array of arrays containing details on fields to update
//         */
//        $connectionsToUpdate = array(
//            array(
//                'model'=>'Company',
//                'connection'=>'companiesWorkedWith',
//                'name'=>'worked_with_company'
//            )
//        );

        $user = $this->user->find(Sentry::getUser()->id);

        if (isset($input['company'])){

            $company = Company::find( Input::get('company') );
            $user->company()->associate($company);

            unset($input['company']);
        }

        if (isset($input['title'])){

            $title = Title::find( Input::get('title') );
            $user->title()->associate( $title );

            unset($input['title']);
        }

        if (isset($input['industry'])){

            $industry = Industry::find( Input::get('industry') );
            $user->industry()->associate( $industry );

            unset($input['industry']);
        }

        $user->save(); //might not need since we're using update

        $user = Sentry::getUser();

        if (isset($input['offers_services'])){

            $services = Input::get('offers_services');

            $user->offersServices()->detach();
            $user->offersServices()->sync($services);

            unset($input['offers_services']);
        }

        if ( isset($input['companies_worked_with']) ){

            $companies = Input::get('companies_worked_with');

            $user->companiesWorkedWith()->detach();
            $user->companiesWorkedWith()->sync($companies);

            unset($input['companies_worked_with']);

        }

        if (isset($input['seeking_titles'])){

            $titles = Input::get('seeking_titles');

            $user->seekingTitles()->detach();
            $user->seekingTitles()->sync($titles);

            unset($input['seeking_titles']);
        }

        if (isset($input['target_industries'])){

            $industries = Input::get('target_industries');

            $user->targetIndustries()->detach();
            $user->targetIndustries()->sync($industries);

            unset($input['target_industries']);
        }

        if (isset($input['network_with_titles'])){

            $titles = Input::get('network_with_titles');

            $user->networksWithTitles()->detach();
            $user->networksWithTitles()->sync($titles);

            unset($input['network_with_titles']);
        }

        if (isset($input['complementary_services'])){

            $services = Input::get('complementary_services');

            $user->complementaryServices()->detach();
            $user->complementaryServices()->sync($services);

            unset($input['complementary_services']);
        }

        $user->update($input);

        return 'OK';
   }

     /**
     * Updates without validation, used in steps or ajax calls
     *
     * @param  int  $id
     * @return Response
     */
    public function updatePassword()
    {
        $input = array_except(Input::all(), '_method');
        
        $user = $this->user->find(Sentry::getUser()->id);
        $user->update($input);

        Sentry::logout();

        return Redirect::route('login')->with('success', 'Great! Try out your new password');
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update()
    {
        $input = array_except(Input::all(), '_method');
        $validation = Validator::make($input, User::$profile_completed,User::$messages);
        
        if ($validation->passes())
        {
            $user = $this->user->find(Sentry::getUser()->id);
            $user->update($input);

            if(array_key_exists('password', $input))
            {
               $user = Sentry::getUser();
               $user->password = $input['password'];
               $user->save();
               Sentry::logout();
               return Redirect::route('login')->with('message', 'Great! Try out your new password.');
            }
           return Redirect::route('profile')->with('success', 'Great! Your changes have been saved.');
       }
       return Redirect::route('profile.edit')->with('errors', $validation->messages())->with('error','Your profile has a few errors: ' .  $validation->messages());
   }


   public function update_picture()
   {
        if(Input::hasFile('photo'))
        {
            $name = md5(uniqid());            
            $file = Image::make(Input::file('photo')->getRealPath());            
            
            $file->resize(140,140,true)->save( public_path().'/users/'.$name.'.jpg');
            
            $user = User::findOrFail(Sentry::getUser()->id);
            $user->photo = $name.'.jpg';
            $user->save();
            Session::flash('success','Profile photo successfully updated');
        }
        else
        {
            Session::flash('error-pic','No photo uploaded. Please try again');
        }
        return Redirect::to('profile.edit');
   }

   public function delete_picture()
   {
        $user = User::findOrFail(Sentry::getUser()->id);
        $file = public_path().'/users/'.$user->photo;
        if(file_exists($file)) 
            unlink($file);
        $user->photo = null;
        $user->save();
        Session::flash('success','Profile photo successfully deleted');
        return Redirect::to('profile.edit');
   }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy()
    {
        $user = Sentry::getUser();
        $user->delete();
        return Redirect::route('');
    }

    public function companiesWorkedWith() {
        $user = Sentry::getUser();
        $companies = $user->companiesWorkedWith;
        return Response::json($companies);
    }

    public function offersServices() {
        $user = Sentry::getUser();
        $services = $user->offersServices;
        return Response::json($services);
    }

    public function seekingTitles() {
        $user = Sentry::getUser();
        $titles = $user->seekingTitles;
        return Response::json($titles);
    }

    public function targetIndustries() {
        $user = Sentry::getUser();
        $industries = $user->targetIndustries;
        return Response::json($industries);
    }

    public function networksWithTitles() {
        $user = Sentry::getUser();
        $titles = $user->networksWithTitles;
        return Response::json($titles);
    }

    public function complementaryServices() {
        $user = Sentry::getUser();
        $services = $user->complementaryServices;
        return Response::json($services);
    }

}
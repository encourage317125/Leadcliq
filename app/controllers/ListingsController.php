<?php


class ListingsController extends BaseController
{

    private static $LIMIT_MASS_UPLOAD = 100;

    public function create()
    {

        if (Input::get('id')){
            $listing = Listing::find(Input::get('id'));

            //don't let people edit published listings
            if ($listing->is_published){
                return Redirect::to('listings/'.$listing->id);
            }
            $listing_type = $listing->listing_type;
        }else{
            $listing_type = Input::get('listing_type')?Input::get('listing_type'):"contact";
        }

        return View::make('listings.create')
            ->with('circles',User::find(Sentry::getUser()->id)->circles()->lists('name','circle_id'))
            ->with('companies',Company::all()->lists('name','id'))
            ->with('titles',Title::all()->lists('name','id'))
            ->with('industries',Industry::all()->lists('name','id'))
            ->with('dealSizeTiers',DealSizeTier::all()->lists('name','id'))
            ->with('companySizeTiers',CompanySizeTier::all()->lists('name','id'))
            ->with('listing_type',$listing_type)
            ->with('listing',isset($listing)?$listing:false);
    }
    
    public function store()
    {
        //Format Data
        $values = Input::except('_token');
        unset($values['zip']);

        $circle_ids = isset($values['circle_ids'])?$values['circle_ids']:array();
        unset($values['circle_ids']);

        $publish = lcfirst($values['submit'])==="publish";
        unset($values['submit']);

        $values['seller_id'] = Sentry::getUser()->id;

        //Create or Find Listing
        if (!isset($values['id']) || !$values['id']){
            $listing = Listing::create($values);
        }else{
            //todo: we need to decide what to do if this has already been modified!
            $listing = Listing::find($values['id']);
            $listing->update($values);
        }
        $listing->circles()->sync($circle_ids);


        //if saving as a draft redirect to listings list
        if (!$publish){
            return Redirect::to('my-listings');
        }

        //Validate and publish if "publish" set

        //Each type of listing has different rules for publishing
        //generate a validator based on type
        switch($values['listing_type']){
            case 'apptshare':
                $type_rules = Listing::$publish_apptshare_rules;
                break;
            case 'opportunity':
                $type_rules = Listing::$publish_opportunity_rules;
                break;
            default :
                $type_rules = Listing::$publish_contact_rules;
        }
        $rules = array_merge($type_rules, Listing::$publish_listing_rules);
        $validation = Validator::make($values,$rules);
        if (!$validation->passes()){
            return Redirect::to('listings/create')
                ->withInput()
                ->withErrors($validation);
        }

        $listing->publish();

        return Redirect::to('listings/'.$listing->id);

    }


    public function show($id)
    {
        $listing = Listing::find($id);

        //disable viewing unpublished listings for now TODO: Make show listing work for unpublished
        if (!$listing->is_published){
            Redirect::to('my-listings');
        }

        //disable viewing if not seller for now TODO: Make show listing work for non-sellers (see apptshares)
        if (!$listing->seller_id!=Sentry::getUser()->id){
            Redirect::to('my-listings');
        }

        return View::make('listings.show')->with('listing',$listing);
    }
    
    /**
     * Receives the File and shows the modal-mass-upload
     */
    public function parseFile(){
        $input = Input::all();
        
        $file = $input['file'];
        
        if(!file_exists($file) || !is_readable($file) || pathinfo($_FILES["file"]['name'], PATHINFO_EXTENSION) != 'csv' ){
            
            return Redirect::route('my-listings')->with('message', "Sorry, there was an error with your file, check that is a correct CSV file.");
        }
        
        $data = $this->getCsvFileData($file);
        $user = $this->getLoguedUser();
                    
      
        $listing_type = Input::get('listing_type')?Input::get('listing_type'):"contact";
   
        
        $listings = Listing::sellingListings(Sentry::getUser()->id);

        echo View::make('listings.my-listings', compact('listings'));        
           
        echo View::make('listings.modal-mass-upload', compact('data'));
        
        echo "<script>$('#modal-mass-upload').modal('show')</script>";
            
        return;
    }

    /**
     * Reads a CSV file and stores all the contacts
     *                                                                                                              
     * @param  $file filename
     * @return array
     */
    private function getCsvFileData($file){
        // Cross OS fix
        ini_set('auto_detect_line_endings', '1');
    
        $header = NULL;
        $listings = array();
        $data = array();
           
        if (($handle = fopen($file, 'r')) !== FALSE){
            
            while (($row = fgetcsv($handle, 10000, ",")) !== FALSE){
                if(!$header){
                    $header = $row;
                }else{
                    if(sizeof($header) == sizeof($row)){
                        array_push($listings, $row);
                    }
                }
            }
            
            fclose($handle);
        }
           
        $data['listings'] = $listings;
        $data['header'] = $header;
        
        
        return $data;
    }

    /**
     * Stores contacts in batchs see modal-mass-upload for POST structure
     */
    public function saveMassListings(){


        $input = Input::all();

        $header = $input['header'];
        $listings = $input['listings'];

        $user_id = Sentry::getUser()->id;

        $errors = '';


        foreach ($listings as $i => $listing) {
            $has_errors = false;

            $data = array();
            foreach ($header as $key => $name) {
                if(strstr($name, 'none_') == false && key_exists($key, $listing)){
                    $data[$name] = $listing[$key];
                }
            }

            //  if($this->contactExists('email', $data['email'])){
//                $errors .= '<p>Listing #<strong>'.($i+1).'</strong>: '.$data['email'].' is already within your contacts';
//                $has_errors = true;
//            }

            if($i > ListingsController::$LIMIT_MASS_UPLOAD){
                return Redirect::route('my-listings')->with('message', 'Sorry, we can only process '.ListingsController::$LIMIT_MASS_UPLOAD.' contacts per file, trim your file and try again.');
            }

            $data['seller_id'] = $user_id;
            $zip=$data['zip'];

            unset($data['zip']);

            $cities=City::where('zip',$zip)->take(1)->get();

            if (sizeof($cities)>0){
                $data['city_id']=$cities[0]->id;
            }
            else{

                $has_errors = true;

                $vals = '<ul class="list-group">';

                $vals .= "<li class='list-group-item'>Zip code is invalid.</li>";

                $vals .= '</ul>';

                $errors .= '<p>Listing #<strong>'.($i+1).'</strong> was not saved: ' . $vals . '</p>';
            }

            //$validation = Validator::make($data, Listing::$rules);
//            
//            if (!$validation->passes()){
//                $has_errors = true;

//                $vals = '<ul class="list-group">';
//                foreach ($validation->messages()->all() as $message) {
//                    $vals .= "<li class='list-group-item'>$message</li>";
//                }
//                $vals .= '</ul>';
//                $errors .= '<p>Contact #<strong>'.($i+1).'</strong> was not saved: ' . $vals . '</p>';
//            }

            //Only stores the correct ones
            if(!$has_errors){
                // Add owner user_id
                $data['seller_id'] = $user_id;
                //$listing = $this->listing->create($data);
                Listing::create($data);
                //  $transaction = new ContactTransactionsController();
//                $transaction->putPrivate($contact->id);
            }
        }

        return Redirect::route('my-listings')->with('message',  'Great! Go to <a href="/my-listings">My Listings</a> to manage your uploaded listings. <br />' . $errors);
    }
    
}
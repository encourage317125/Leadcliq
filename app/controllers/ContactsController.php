
<?php

use Illuminate\Support\Facades\Auth;
class ContactsController extends BaseController {

	private static $LIMIT_MASS_UPLOAD = 100;
	
	/**
	 * Contact Repository
	 *
	 * @var Contact
	 */
	protected $contact;

	public function __construct(Contact $contact)
	{
		$this->contact = $contact;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = $this->getLoguedUser();
		
		$aux = State::select('name', 'code')->get();
		$states = array();
		foreach ($aux as $state) {
			$states[$state->code] = $state->name;
		}
	
		//Hardcoded for the 1st state in the DB
		$aux = City::select('name')->where('state_code', '=', 'AL')->get();
		$cities = array();
		foreach ($aux as $city) {
			$cities[$city->name] = $city->name;
		}
	
		return View::make('contacts.create', compact('user', 'states', 'cities'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$contact = $this->contact->find($id);
	
		if (is_null($contact)){
			return Redirect::route('contacts.index');
		}
	
		$user = $this->getLoguedUser();
	
		$aux = State::select('name', 'code')->get();
		$states = array();
		foreach ($aux as $state) {
			$states[$state->code] = $state->name;
		}
	
		$aux = City::select('name')->where('state_code', '=', $contact->state)->get();
		$cities = array();
		foreach ($aux as $city) {
			$cities[$city->name] = $city->name;
		}
	
		return View::make('contacts.edit', compact('contact', 'user', 'states', 'cities'));
	}


	

	/**
	 * Removes a contact and reedirects to my-contacts
	 *
	 */
	public function delete($id)
	{
		$contact = $this->contact->find($id);
		$name = $contact->first_name . ' ' . $contact->last_name;

		// Control owner is logued in
		if ($contact->user_id != Sentry::getUser()->id){
			return Redirect::route('my-contacts')->with('message', 'Only the owner can delete this contact');
		}
		
		// Only private contacts
		if($contact->getRawStatus() != ContactTransaction::$CONTACT_PRIVATE){
			return Redirect::route('my-contacts')->with('message', 'Only the private contacts can be deleted. This contact is <strong>' . $contact->getStatus() . '</strong>');	
		}

		$contact->delete();
		
		return Redirect::route('my-contacts')->with('message', $name . " was deleted from contacts");
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function modalEdit($id)
	{
		$contact = $this->contact->find($id);
	
		if (is_null($contact)){
			return Redirect::route('contacts.index');
		}
	
		// Only private contacts
		if($contact->getRawStatus() != ContactTransaction::$CONTACT_PRIVATE){
			return Redirect::route('my-contacts')->with('message', 'Only the private contacts can be edited. This contact is <strong>' . $contact->getStatus() . '</strong>');	
		}

		$aux = State::select('name', 'code')->get();
		$states = array();
		foreach ($aux as $state) {
			$states[$state->code] = $state->name;
		}
		
		$aux = City::select('name')->where('state_code', '=', $contact->state)->get();
		$cities = array();
		foreach ($aux as $city) {
			$cities[$city->name] = $city->name;
		}
		
		$user = $this->getLoguedUser();
		return View::make('contacts.modal.modal-edit-contact', compact('contact', 'user', 'states', 'cities'));
	}
	
	/**
	 * Receives the File and shows the modal-mass-upload
	 */
	public function parseFile(){
		$input = Input::all();
		
		$file = $input['file'];
		
		if(!file_exists($file) || !is_readable($file) || pathinfo($_FILES["file"]['name'], PATHINFO_EXTENSION) != 'csv' ){
			return Redirect::route('contacts.create')->with('message', "Sorry, there was an error with your file, check that is a correct CSV file.");
		}
		
		$data = $this->getCsvFileData($file);
		$user = $this->getLoguedUser();
			
		echo View::make('contacts.create', compact('user'));
		echo View::make('contacts.modal-mass-upload', compact('data'));
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
		$contacts = array();
		$data = array();
	
		if (($handle = fopen($file, 'r')) !== FALSE){
			
			while (($row = fgetcsv($handle, 10000, ",")) !== FALSE){
				if(!$header){
					$header = $row;
				}else{
					if(sizeof($header) == sizeof($row)){
						array_push($contacts, $row);
					}
				}
			}
			
			fclose($handle);
		}
	
		$data['contacts'] = $contacts;
		$data['header'] = $header;
	
		return $data;
	}
	
	
	/**
	 * Stores contacts in batchs see modal-mass-upload for POST structure
	 */
	public function saveMassContacts(){
		$input = Input::all();
		
		$header = $input['header'];
		$contacts = $input['contacts'];
		$user_id = Sentry::getUser()->id;
		
		$errors = '';

		foreach ($contacts as $i => $contact) {
			$has_errors = false;

			$data = array();
			foreach ($header as $key => $name) {
				if(strstr($name, 'none_') == false && key_exists($key, $contact)){
					$data[$name] = $contact[$key];
				}
			}
		
			if($this->contactExists('email', $data['email'])){
				$errors .= '<p>Contact #<strong>'.($i+1).'</strong>: '.$data['email'].' is already within your contacts';
				$has_errors = true;
			}
				
			if($i > ContactsController::$LIMIT_MASS_UPLOAD){
				return Redirect::route('contacts.create')->with('message', 'Sorry, we can only process '.ContactsController::$LIMIT_MASS_UPLOAD.' contacts per file, trim your file and try again.');
			}
		
			$data['user_id'] = $user_id;
			$validation = Validator::make($data, Contact::$rules);
			if (!$validation->passes()){
				$has_errors = true;

				$vals = '<ul class="list-group">';
				foreach ($validation->messages()->all() as $message) {
					$vals .= "<li class='list-group-item'>$message</li>";
				}
				$vals .= '</ul>';
				$errors .= '<p>Contact #<strong>'.($i+1).'</strong> was not saved: ' . $vals . '</p>';
			}

			//Only stores the correct ones
			if(!$has_errors){
				// Add owner user_id
				$data['user_id'] = $user_id;
				$contact = $this->contact->create($data);
				$transaction = new ContactTransactionsController();
				$transaction->putPrivate($contact->id);
			}
		}

		return Redirect::route('contacts.create')->with('message',  'Great! Go to <a href="/my-contacts">My Contacts</a> to manage your uploaded contacts. <br />' . $errors);
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$input['user_id'] = Sentry::getUser()->id;
		
		$circle_id = $input['circle_id'];
		unset($input['circle_id']);

		$validation = Validator::make($input, Contact::$rules);

		if ($validation->passes()){

			if($this->contactExists('email', $input['email'])){
				return Redirect::route('contacts.create')->with('message', 'Sorry, the email '.$input['email'].' already exists in your contacts.');	
			}

			$contact = $this->contact->create($input);
			$transaction = new ContactTransactionsController();
			$transaction->putPrivate($contact->id);

			return Redirect::route('sell-contact-how', $contact->id)->with('message', 'New contact created.');	
		}

		return Redirect::route('contacts.create')
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors' );
	}

	/**
	 * Get specified resource.
	 *
	 * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
	public function get($id)
	{
		return $this->contact->findOrFail($id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$contact = $this->contact->findOrFail($id);
		$user = $this->getLoguedUser();

		return View::make('contacts.show', compact('contact', 'user'));
	}

	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showBougthContact($id)
	{
		$contact = $this->contact->find($id);
	
		if (is_null($contact)){
			return Redirect::route('contacts.index');
		}
	
		$user = $this->getLoguedUser();
		$owner = $contact->owner;
		$feedback = $contact->feedback;

		return View::make('contacts.modal.modal-show-bought-contact', compact('owner', 'contact', 'user', 'feedback'));
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function modalOpprtEdit($id)
	{
		$contact = $this->contact->find($id);
	
		if (is_null($contact)){
			return Redirect::route('contacts.index');
		}
	
		$user = $this->getLoguedUser();
		return View::make('contacts.modal.modal-opportunity-contact', compact('contact', 'user'));
	}
	
	/**
	 * Removes a contact from the call list
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function removeCallList($id){
		$contact = $this->contact->findOrFail($id);
		$contact->call_list = Contact::$REMOVE_CALL_LIST;
		$contact->save();

		return 'OK';
	}

	/**
	 * Updates a contact wihout render view
	 * Does NOT validate input, use with caution
	 * 
	 * TODO add owner security
	 * 
	 * @param unknown $id
	 * @return string
	 */
	public function updateOnly($id){
		$input = array_except(Input::all(), '_method');
		$contact = $this->contact->find($id);

		// Only private contacts
		if($contact->getRawStatus() != ContactTransaction::$CONTACT_PRIVATE){
			return Redirect::route('my-contacts')->with('message', 'Only the private contacts can be edited. This contact is <strong>' . $contact->getStatus() . '</strong>');	
		}

		$contact->update($input);
		
		return 'OK';
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)	{
		$input = array_except(Input::all(), '_method');
		$input['user_id'] = Sentry::getUser()->id;

		$validation = Validator::make($input, Contact::$rules);

		if ($validation->passes())
		{
			$contact = $this->contact->find($id);

			// Only private contacts
			if($contact->getRawStatus() != ContactTransaction::$CONTACT_PRIVATE){
				return Redirect::route('my-contacts')->with('message', 'Only the private contacts can be edited. This contact is <strong>' . $contact->getStatus() . '</strong>');	
			}

			$contact->update($input);

			return Redirect::route('my-contacts')->with('message', 'Contact has been updated correctly.');
		}

		return Redirect::route('contacts.edit', $id)
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
		$this->contact->find($id)->delete();

		return Redirect::route('my-contacts');
	}


	/**
	 * Checks if a contacts exists and belongs to the logued User
	 *
	 * @param $field field to look by in the DB
	 * @param $value value of the looked field
	 * @return true or false
	 */
	public function contactExists($field, $value){
		if(DB::table('contacts')->where($field, '=', $value)->where('user_id', '=', Sentry::getUser()->id)->count() > 0){
			return true;
		}

		return false;
	}	

	/**
	 * Shows the step1 to sell contact
	 *
	 * @param $id Contact id
     * @return \Illuminate\View\View
     */
	public function sellContactHow($id){
		$contact = $this->contact->findOrFail($id);
		$user = $this->getLoguedUser();

		return View::make('contacts.sell.sell-contact-how', compact('contact', 'user'));
	}


	/**
	 * Shows the step1 to sell contact
	 *
	 * @param $id Contact id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
	public function sellContactMoney($id){
		$contact = $this->contact->findOrFail($id);

		if($contact->getRawStatus() != ContactTransaction::$CONTACT_PRIVATE){
			return Redirect::route('my-contacts');
		}

		$user = $this->getLoguedUser();

		return View::make('contacts.sell.sell-contact-money', compact('contact', 'user'));
	}

	/**
	 * Shows the step1 to sell contact
	 * @param $id Contact id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
	public function sellContactPoints($id){
		$contact = $this->contact->findOrFail($id);

		if($contact->getRawStatus() != ContactTransaction::$CONTACT_PRIVATE){
			return Redirect::route('my-contacts');
		}

		$user = $this->getLoguedUser();

		return View::make('contacts.sell.sell-contact-points', compact('contact', 'user'));
	}

    /**
     * @param $id
     * @return \Illuminate\View\View
     */
    public function showHistory($id){
		$contact = $this->contact->findOrFail($id);
		$user = $this->getLoguedUser();

		return View::make('contacts.modal.show-history', compact('contact', 'user'));			
	}

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function pay($id){
        $contact = $this->contact->findOrFail($id);

        if(Input::server('REQUEST_METHOD') == "POST")
        {
            //todo: validate contact is still on the market!!
            $amount = $contact->price;
            $marketplace = new Leadcliq\Repositories\Payments\BalancedPayments();
            $paymentData = array(
                'amount' => $amount,
                'description' => 'Payment for: '.$contact->title.'. Contact ID: '.$contact->id,
                'meta' => array(
                    'paid_for' => 'contact',
                    'paid_id' => $contact->id,
                ),
            );

            $payment = $marketplace->buy($paymentData,'card',Input::get('card'));

            if(is_array($payment)){
                $message = ("Debit Status: ".$payment['status'].". Reason: ".$payment['reason']);
                return Redirect::route('buy-contact', $id, 0);
            }
            $message = ("Successfully purchased $payment->paid_for: $payment->description ");
            return Redirect::route('my-contacts')->with($message);
        }

        $cards = Sentry::getUser()->cards()->lists('last_four','uri');

        if (count($cards)===0){
            return Redirect::route('credit-cards.create',array('redirect'=>Request::url()));
        }

        // $banks = $marketplace->getBanks();
        return View::make('contacts.pay')->with('contact',$contact)->with('cards',$cards);//->with('banks',$banks);
    }

    public function paypalPay($contact_id){
        $contact = $this->contact->findOrFail($contact_id);
        $seller = $contact->seller;
        $buyer = Sentry::getUser();
        return View::make('contacts.pay-paypal')->with('contact',$contact)->with('seller',$seller)->with('buyer',$buyer);//->with('banks',$banks);
    }

    public function paypalPayFinish($contact_id){
        if(Input::server('REQUEST_METHOD') == "POST"){
            $data = Input::all();
            $buyer = Sentry::getUser();
            $contact = $this->contact->findOrFail($contact_id);
            $contact->markSold($buyer->id);
            $message = ("Successfully purchased $contact->title using PayPal ");
            return Redirect::route('my-contacts')->with($message);
        }
    }
}






















<?php


class ApptShareController extends BaseController
{
	protected $apptshares;

	public function __construct(ApptSharesInterface $apptshares)
	{
		$this->apptshares = $apptshares;
	}

	public function index()
	{
		$appts = $this->apptshares->getMine();
		if (Request::ajax() or Request::isJson() or Request::wantsJson())
		{
			return Response::json($appts->toArray(),200);
		}
		return View::make('apptshares.list')->with('appts',$appts);
	}

	public function show($id)
	{
		$appt = $this->apptshares->get($id);
		return View::make('apptshares.show')->with('appt',$appt);
	}

	public function create()
	{
		
		return View::make('apptshares.create')->with('circles',User::find(Sentry::getUser()->id)->circles()->lists('name','circle_id'));
	}

	public function store()
	{
		$result = $this->apptshares->store(Input::except('_token'));
		if(is_numeric($result))
		{
			return Redirect::to('apptshares/'.$result);
		}		
		return Redirect::to('apptshares/create')->withInput()->withErrors($result);
	}

	public function edit($id)
	{
		$apptshare = $this->apptshares->get($id);
		return View::make('apptshares.edit')->with('circles',User::find(Sentry::getUser()->id)->circles()->lists('name','circle_id'))->with('apptshare',$apptshare);
	}

	public function update($id)
	{
		$result = $this->apptshares->update($id,Input::except('_token','_method'));
		if(is_numeric($result))
		{
			return Redirect::to('apptshares/'.$result);
		}		
		return Redirect::to('apptshares/edit')->withInput()->withErrors($result);
	}

	public function makePublic($id)
	{
		if($this->apptshares->makePublic($id))
			Session::flash('success','Appointment now public.');
		return Redirect::route('apptshares.show',$id);
	}

	public function makePrivate($id)
	{
		if($this->apptshares->makePrivate($id))
			Session::flash('success','Appointment is now private');
		return Redirect::route('apptshares.show',$id);
	}

	public function market()
	{
		$appts = $this->apptshares->getPublicAppts();
		if (Request::ajax() or Request::isJson() or Request::wantsJson())
		{
			return Response::json($appts->toArray(),200);
		}
		return View::make('apptshares.list')->with('appts',$appts)->with("page_title","Open Market");
	}

	public function circle($id)
	{
		$appts = $this->apptshares->getCircleAppts($id);
		if (Request::ajax() or Request::isJson() or Request::wantsJson())
		{
			return Response::json($appts->toArray(),200);
		}
		return View::make('apptshares.list')->with('appts',$appts)->with("page_title","Circle: ".Circle::find($id)->name);
	}

	public function myBids()
	{
		$appts = $this->apptshares->getMine();
		$bids = $this->apptshares->getMyBids();
		if (Request::ajax() or Request::isJson() or Request::wantsJson())
		{
			return Response::json($bids,200);
		}
		return View::make('apptshares.list')->with('appts',$appts)->with('bids',$bids)->with("page_title","My Bids");
	}

	public function bid()
	{
		$bid = $this->apptshares->makeBid(Input::all());
		if(Request::ajax()) 
			return Response::json($bid->toArray());
	}

	public function accept($id)
	{
		$appt = $this->apptshares->acceptBid($id);
		return Redirect::route('apptshares.show',$appt);
	}

	public function reject($id)
	{
		$appt = $this->apptshares->rejectBid($id);
		return Redirect::route('apptshares.show',$appt);
	}

	public function rejectAll($id)
	{
		$this->apptshares->rejectAll($id);
		return Redirect::route('apptshares.show',$id);
	}

	public function pay($id)
	{
		$appt = $this->apptshares->get($id);
		

		if(Input::server('REQUEST_METHOD') == "POST")
		{
			$amount = 100 * ($appt->pay_option=='one_price'? $appt->price : $appt->checkpoints()->sum('amount'));
			$marketplace = App::make('Leadcliq\Repositories\Payments\PaymentsContract');
			$meta = array('paid_for'=>'ApptShare','paid_id'=> $appt->id);
			$payment = $marketplace->chargeCard($amount,'Leadcliq payment for apptshare: '.$appt->title, $meta, Input::get('card'));
			$appt = $this->apptshares->paid($id,$payment);
			return Redirect::route('apptshares.show',$id);
		}
		$cards = Sentry::getUser()->cards()->lists('last_four','uri');

		// $banks = $marketplace->getBanks();
		return View::make('apptshares.pay')->with('appt',$appt)->with('cards',$cards);//->with('banks',$banks);
	}
    
    //user_territories
    public function territory()
    {
        $locations=DB::table('cities')->join('users_territories', 'cities.id', '=', 'users_territories.location_id')        
        ->where('users_territories.user_id', '=', Sentry::getUser()->id)
        ->get();
        
        //build zip codes
        $zips=array();
        foreach($locations as $location){
            $zips[]=$location->zip;
        }
       
       $apptshares =  DB::table('apptshares')->whereIn('zip', $zips)->get();
                    
        return Response::json($apptshares );
    }
}
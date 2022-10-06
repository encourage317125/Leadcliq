<?php namespace Eloquent;

use ApptShare;
use ApptShareBid;
use ApptShareCheckpoint;
use ApptSharesInterface;
use Session;
use Validator;
use Sentry;
use DB;

class ApptSharesRepository implements ApptSharesInterface
{
	protected $model, $checkpoint;

	public function __construct(ApptShare $model, ApptShareCheckpoint $checkpoint)
	{
		$this->model = $model;
		$this->checkpoint = $checkpoint;
	}

	public function get($id)
	{
		return $this->model->with(array('owner','checkpoints','city','city.state'))->find($id);
	}

	public function getAll()
	{
		return $this->model->with(array('owner','checkpoints'))->get();
	}

	public function getPublicAppts()
	{
		return $this->model->with(array('owner','checkpoints'))->where('status','public')->where('sell_for','money')->where('bid_datetime','>',date('Y-m-d H:i:s'))->orderBy('appt_datetime')->get();
	}

	public function getCircleAppts($id)
	{
		return $this->model->with(array('owner','checkpoints'))->where('status','public')->where('circle_id',$id)->where('bid_datetime','>',date('Y-m-d H:i:s'))->orderBy('appt_datetime')->get();
	}

	public function getMine()
	{
		return $this->model->ownedBy(Sentry::getUser()->id)->get();
	}

	public function getMyBids()
	{
		return ApptShareBid::where('apptshares_bids.bidder_id',Sentry::getUser()->id)->with('apptshare','apptshare.owner')->get();
	}

	public function validate($input, $rules)
	{
		array_walk($rules, function($value, $key){
			if(strpos($value, 'unique') === 0)
			{
				str_replace('null', '', $value);
			}
		});
		return Validator::make($input, $rules);
	}

	public function setInput(&$instance, $input)
	{		
		foreach ($input as $key => $value) 
		{
			if(str_contains($key,'checkpoint')) continue;
			$instance->$key = $value;
		}
		if(!isset($instance->user_id))
			$instance->user_id = Sentry::getUser()->id;
	}	

	public function store($input)
	{
		$validation = $this->validate($input, $this->model->rules);		
		if (!$validation->fails())
		{			
			$apptshare = $this->model->instance();
			$this->setInput($apptshare, $input);
			$apptshare->save();
			$i = 1;
			while(array_key_exists('checkpoint_'.$i.'_title',$input ))
			{
				$checkpoint = array(
					'title' => $input['checkpoint_'.$i.'_title'],
					'description' => $input['checkpoint_'.$i.'_description'],
					'amount' => $input['checkpoint_'.$i.'_amount'],
					 );
				$checkpoint = $this->checkpoint->create($checkpoint);
				$apptshare->checkpoints()->save($checkpoint);
				$i++;
			}
			return $apptshare->id;
		}
		return $validation;
	}

	public function update($id, $input)
	{
		$validation = $this->validate($input, $this->model->rules);		
		if (!$validation->fails())
		{			
			$apptshare = $this->get($id);
			$this->setInput($apptshare, $input);
			$apptshare->save();
			$i = 1;
			while(array_key_exists('checkpoint_'.$i.'_title',$input ))
			{
				$checkpoint = array(
					'title' => $input['checkpoint_'.$i.'_title'],
					'description' => $input['checkpoint_'.$i.'_description'],
					'amount' => $input['checkpoint_'.$i.'_amount'],
					 );
				$checkpoint = $this->checkpoint->create($checkpoint);
				$apptshare->checkpoints()->save($checkpoint);
				$i++;
			}
			return $apptshare->id;
		}
		return $validation;
	}

	public function makePrivate($id)
	{
		$appt = ApptShare::find($id);
		$appt->status = 'private';
		return $appt->save();
	}

	public function makePublic($id)
	{
		$appt = ApptShare::find($id);
		$appt->status = 'public';
		return $appt->save();
	}

	public function makeBid($input)
	{
		$bid = ApptShareBid::where('apptshare_id',$input['apptshare_id'])->where('bidder_id',$input['bidder_id'])->first();
		if ($bid)
		{
			$bid->message .= $input['message'];
			$bid->save();
			Session::flash('info','You already have a bid on this item');
			return $bid;
		}
		return ApptShareBid::create($input);
	}

	public function rejectBid($id)
	{
		$bid = ApptShareBid::find($id);
		$bid->status = 'rejected';
		$bid->save();
		if($bid->apptshare->bids()->where('status','accepted')->count() == 0)
		{
			$bid->apptshare->status = 'public';
			$bid->apptshare->save();
		}
		return $bid->apptshare_id;
	}

	public function acceptBid($id)
	{
        if ($this->model->sell_for === 'money'){
            if (!$this->putIntoEscrow()){
                $this->rejectBid($id);
                return false;
            }
        }
		$bid = ApptShareBid::find($id);
		$bid->status = 'accepted';
		$bid->save();
		$bid->apptshare->status = "sold";
		$bid->apptshare->save();
		return $bid->apptshare_id;
	}

    public function putIntoEscrow()
    {
//        //if single payment
//        if ($this->model->pay_option === 'multiple-payout'){
//            //put
//        }
//
//        //if checkpoints
        return true;
    }

	public function rejectAll($id)
	{
		foreach(ApptShareBid::where('apptshare_id',$id)->pending()->get() as $bid)
		{
			$this->rejectBid($bid->id);
		}
		return;
	}

	public function paid($id,$payment)
	{
		$appt = $this->get($id);
		$appt->status = 'sold';
		return $appt->save();
	}

}
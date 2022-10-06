<?php

class Message extends Eloquent
{
    /**
     * Make sure no attributes are accessible
     * (we're only going to use Eloquent in here)
     * all attribute access should be wrapped in internal methods
     * @var array
     */
    protected $fillable = array(
        'subject',
        'to',
        'from',
        'message',
        'sent_at'
    );

    public static $canSend = array(
        'subject'=>'required',
        'to'=>'required',
        'from'=>'required',
    );

    /*********************
     * Relationships
     *********************/

    public function toUser()
    {
        return $this->belongsTo('User','to');
    }

    public function fromUser()
    {
        return $this->belongsTo('User','from');
    }

    /*********************
     * Scopes
     *********************/

    /**
     * Retrieves messages that haven't been archived
     * @param $user_id
     */
    public static function getUsersNewMessages($user_id)
    {
        Message::whereTo($user_id)->whereNull('sent_at')->get();
    }

    /**
     * Retrieves all a users messages that weren't deleted
     * @param $user_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public static function getUserMessages($user_id)
    {
        return Message::where('to',$user_id)->get();
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public static function scopeUserSentMessages($query,$user_id)
    {
        return $query->where('from',$user_id)->whereNotNull('sent_at');
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public static function scopeUserDraftMessages($query,$user_id)
    {
        return $query->where('from',$user_id)->whereNull('sent_at');
    }
    
    /**
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public static function archiveMessages()
    {        
        $affectedRows = Message::whereNull('archived_at')->update(array('archived_at' => date('Y-m-d H:m:s')));
           
        
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public static function scopeUserInboxMessages($query, $user_id){
        return $query->where('to',$user_id)->whereNotNull('sent_at')->whereNull('archived_at');
    }

    /**
     * @param $query \Illuminate\Database\Eloquent\Builder
     * @param $user_id
     * @return array|\Illuminate\Database\Eloquent\Collection|static
     */
    public static function scopeUserArchivedMessages($query, $user_id){
        return $query->where('to',$user_id)->whereNotNull('sent_at')->whereNotNull('archived_at');
    }

    /*********************
     * Helpers
     *********************/

    public function isSent(){
        return $this->sent_at!==NULL;
    }

    /*********************
     * API
     *********************/

    /**
     * @param array $input
     * @throws Exception
     * @internal param array $array
     * @return \Illuminate\Database\Eloquent\Model|void|static
     */
    public static function createOrUpdate($input)
    {

    }

    /**
     * Sets the archived_at parameter as a timestamp
     * Provides a way to sort read/not read message
     * (can't use read_at timestamp because we'll be displaying in dashboard)
     *
     * @param $id
     */
    public function archive($id)
    {
        $message = Message::find($id);
        $message->archived_at =  date('Y m d H:m');
        $message->save();
    }

    /**
     * Soft deletes a message
     *
     * @param $id
     * @return bool|null|void
     */
    public function deleteMessage($id)
    {
        Message::find($id)->delete();
    }

    /**
     * Retuns all
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public static function getByID($id)
    {
        return Message::find($id);
    }

    /**
     * Returns all draft messages by user (with pagination)
     *
     * @param $user_id
     * @param int $start
     * @param int $amount
     * @return Collection
     */
    public static function drafts($user_id,$start=0,$amount=100)
    {
        $message = Message::where('from',$user_id)
            ->whereNull('sent_at')
            ->skip($start)->take($amount)->get();
        return $message;
    }

    /**
     * Returns all messages sent by user (with pagination)
     *
     * @param $user_id - the user message sent from
     * @param int $start
     * @param int $amount
     * @return array|static
     */
    public static function sent($user_id,$start=0,$amount=100)
    {
        $message = Message::where('from',$user_id)
            ->whereNotNull('sent_at')
            ->skip($start)->take($amount)->get();
        return $message;
    }

    /**
     * Returns all messages not archived by user (with pagination)
     * @param $user_id - the user message sent from
     * @param int $start
     * @param int $amount
     * @return array|static
     */
    public static function inbox($user_id,$start=0,$amount=100)
    {
        $messages = Message::where('to',$user_id)
            ->whereNull('archived_at')
            ->skip($start)->take($amount)->get();

        return $messages;
    }

    /**
     * Returns all messages to user (with pagination)
     * @param $user_id - the user message sent from
     * @param int $start
     * @param int $amount
     * @return array|static
     */
    public static function allMessage($user_id,$start=0,$amount=100)
    {
        $messages = Message::where('to',$user_id)
            ->skip($start)->take($amount)->get();

        return $messages;
    }

    /**
     * @param $user_id
     * @param int $start
     * @param int $amount
     * @return array|static
     */
    public static function archived($user_id,$start=0,$amount=100)
    {
        $message = Message::where('to',$user_id)
            ->whereNotNull('archived_at')
            ->skip($start)->take($amount)->get();
        return $message;
    }

    public static function allMessages($user_id,$start=0,$amount=100){

    }

}
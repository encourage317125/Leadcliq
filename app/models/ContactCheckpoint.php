<?php

class ContactCheckpoint extends Eloquent {
    protected $guarded = array();

    
    public function getContact() {
        return Contact::findOrFail($this->contact_id);
    }
}
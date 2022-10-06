<?php

class Point extends Eloquent {
    protected $guarded = array();

    public function circle() {
        return $this->belongsTo('Circle');
    }

}
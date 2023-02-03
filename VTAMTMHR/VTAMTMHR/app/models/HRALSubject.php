<?php

class HRALSubject extends Eloquent {

    protected $table = 'hralsubject';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

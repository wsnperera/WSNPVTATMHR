<?php

class IRCompany extends Eloquent {

    protected $table = 'ircompany';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

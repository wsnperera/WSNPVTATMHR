<?php

class HREmployeeLoan extends Eloquent {

    protected $table = 'hremployeeloan';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

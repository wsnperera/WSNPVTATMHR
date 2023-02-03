<?php

class HRLoanType extends Eloquent {

    protected $table = 'hrloantype';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

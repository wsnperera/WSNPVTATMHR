<?php

class HROfficeTime extends Eloquent {

    protected $table = 'hrofficetime';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

<?php

class HRIncrementAction extends Eloquent {

    protected $table = 'hrincrementaction';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

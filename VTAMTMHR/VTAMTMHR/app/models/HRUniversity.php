<?php

class HRUniversity extends Eloquent {

    protected $table = 'hruniversity';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

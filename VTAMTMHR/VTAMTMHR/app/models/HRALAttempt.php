<?php

class HRALAttempt extends Eloquent {

    protected $table = 'hralattempt';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

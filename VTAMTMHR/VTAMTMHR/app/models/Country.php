<?php

class Country extends Eloquent
{
    protected  $table = 'country';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false; 
    public static $unguarded = false;
    
    
    
    
}

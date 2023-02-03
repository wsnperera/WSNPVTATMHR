<?php

class HRPersonalFileDocument extends Eloquent {

    protected $table = 'hrpersonalfiledocument';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

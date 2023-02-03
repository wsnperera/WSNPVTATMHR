<?php

class OrganisationType extends Eloquent {

    protected $table = 'organisationtype';  // define your table name here
    protected $primaryKey = 'OT_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

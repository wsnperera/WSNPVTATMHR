<?php

class KPISchedule extends Eloquent {

    protected $table = 'kpischedule';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

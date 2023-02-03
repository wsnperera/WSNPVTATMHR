<?php

class IRTrainee extends Eloquent {

    protected $table = 'irtrainee';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
    
    
   
}

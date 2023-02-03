<?php

class Qualification extends Eloquent {

    protected $table = 'qualification';  // define your table name here
    protected $primaryKey = 'Qualification_ID'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

}

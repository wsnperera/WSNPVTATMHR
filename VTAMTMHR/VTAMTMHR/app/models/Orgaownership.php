<?php

class Orgaownership extends Eloquent {

    protected $table = 'orga_ownership';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;

}

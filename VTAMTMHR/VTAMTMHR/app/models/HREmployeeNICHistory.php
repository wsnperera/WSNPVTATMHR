<?php

class HREmployeeNICHistory extends Eloquent {

    protected $table = 'hremployeenichistory';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
	
	}
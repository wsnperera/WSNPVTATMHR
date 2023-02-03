<?php

class EmployeeType extends Eloquent
{


protected  $table = 'employeetype';  // define your table name here
protected $primaryKey = 'ET_ID'; // define Table primary key
public $timestamps = false; 
public static $unguarded=true;
}
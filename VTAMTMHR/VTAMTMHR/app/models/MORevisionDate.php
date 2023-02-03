<?php
class MORevisionDate extends Eloquent
{
    protected  $table = 'morevisiondates';  // define your table name here
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public static $unguarded=true;
    
    
}
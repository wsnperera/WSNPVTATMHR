<?php
class MOActualTaskSeq extends Eloquent
{
    protected  $table = 'moactualtasksequence';  // define your table name here
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public static $unguarded=true;
    
    
}
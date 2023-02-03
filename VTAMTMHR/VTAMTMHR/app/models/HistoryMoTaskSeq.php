<?php
class HistoryMoTaskSeq extends Eloquent
{
    protected  $table = 'historymotaskseq';  // define your table name here
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public static $unguarded=true;
    
    
}
<?php
class HistoryMoTaskSeqResult extends Eloquent
{
    protected  $table = 'historymotaskseqresult';  // define your table name here
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public static $unguarded=true;
    
    
}
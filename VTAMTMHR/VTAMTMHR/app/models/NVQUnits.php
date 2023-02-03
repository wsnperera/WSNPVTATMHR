<?php
class NVQUnits extends Eloquent
{
    protected  $table = 'nvqunits';  // define your table name here
	protected $primaryKey = 'UID'; // define Table primary key
	public $timestamps = false;
    public static $unguarded = true;
}
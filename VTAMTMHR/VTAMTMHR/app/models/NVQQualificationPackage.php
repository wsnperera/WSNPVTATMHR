<?php
class NVQQualificationPackage extends Eloquent {
	protected $table = 'nvqqualificationpackage';  // define your table name here
    protected $primaryKey = 'id'; // define Table primary key
    public $timestamps = false;
    public static $unguarded = true;
}
?>
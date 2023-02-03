<?php
class NVQcompetencystandard extends Eloquent {
	   protected  $table = 'nvqcompetencystandard';  // define your table name here
	   protected $primaryKey = 'id'; // define Table primary key
	   public $timestamps = false;
       public static $unguarded = true;
}
?>
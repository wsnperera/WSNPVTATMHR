<?php


class District extends Eloquent
{
    
    
		protected  $table = 'district';  // define your table name here
		protected $primaryKey = 'DistrictCode'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;
                
                
                
}

?>

<?php


class Province extends Eloquent
{
    
    
		protected  $table = 'province';  // define your table name here
		protected $primaryKey = 'ProvinceCode'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;
                
                

}

?>

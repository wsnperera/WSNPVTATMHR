<?php


class Trade extends Eloquent 
{
   
		protected  $table = 'trade';  // define your table name here
		protected $primaryKey = 'TradeId'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded = true;
                
                
    
}

?>

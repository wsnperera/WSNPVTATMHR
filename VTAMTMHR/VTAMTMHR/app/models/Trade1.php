<?php


	class Trade1 extends Eloquent
	{


		protected  $table = 'trade';  // define your table name here
		protected $primaryKey = 'TradeId'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded=true;

                  
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'TradeCode' => 'Required',
                        'Letter' => 'Required',
                        'TradeName' => 'Required',
                          //'FullTime' => 'Required',
                          //'PartTime' => 'Required',
                         //'PublicIn' => 'Required',
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }

                

	}


?>

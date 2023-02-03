<?php


	class Holiday extends Eloquent
	{


		protected  $table = 'holiday';  // define your table name here
		protected $primaryKey = 'H_ID'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded=true;

                  
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'HolidayYear' => 'Required',
                        //'HolidayMonth' => 'Required',
                        //'HolidayDay' => 'Required',
                        'PublicIn' => 'Required',
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }

                

	}


?>
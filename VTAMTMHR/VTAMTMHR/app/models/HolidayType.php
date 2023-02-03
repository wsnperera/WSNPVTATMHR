<?php

class HolidayType extends Eloquent
	{


		protected  $table = 'holidaytype';  // define your table name here
		protected $primaryKey = 'HTId'; // define Table primary key
		public $timestamps = false; 

               


	

          public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'HTName' => 'Required',
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }
        }                    
<?php

class Activity extends Eloquent
{
    
                protected  $table = 'activity';  // define your table name here
		protected $primaryKey = 'activityid'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded = true;
                
                
                   public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'routename' => 'Required',
                        'activityname' => 'Required'
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                }
           
                
  
     }

<?php
class MOOLDInstructor extends Eloquent
{
    
    
		protected  $table = 'oldmoinstructor';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;
                
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'Code' => 'Required|unique:nvqelement,Code',
                        'Name' => 'Required|alpha',
                       
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                } 
                
}
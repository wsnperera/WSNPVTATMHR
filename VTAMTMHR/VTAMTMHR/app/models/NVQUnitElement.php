<?php
class NVQUnitElement extends Eloquent
{
    
    
		protected  $table = 'nvqunitelement';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false;
                public static $unguarded = true;
                
                public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'unitId' => 'Required',
                        'elementId' => 'Required',
                       
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                } 
                
}

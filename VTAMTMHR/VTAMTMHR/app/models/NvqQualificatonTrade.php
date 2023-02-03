<?php

class NvqQualificatonTrade extends Eloquent
{
    
    
		protected  $table = 'nvqqualificationtrade';  // define your table name here
		protected $primaryKey = 'id'; // define Table primary key
		public $timestamps = false; 
                
                 public static function validate($inputs)
                {
                    
                     $rules = array
                    ( 
                        'TradeId' => 'Required',
                        'QualificationCode' => 'Required',
                        'Qualification' => 'Required',
                         
                        
                    );
                     
                     
                    return $validator = Validator::make($inputs, $rules);
                    
                    
                } 
                
}

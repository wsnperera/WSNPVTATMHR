<?php

class ActivityType extends Eloquent
{
    
                protected  $table = 'activitytype';  // define your table name here
		protected $primaryKey = 'activityID'; // define Table primary key
		public $timestamps = false; 
                public static $unguarded = true;
                
                
                
                public function Logs()
                {
                    
                    
                    return $this->hasMany('LogData','activityID');
                    
                    
                    
                }
    
}
